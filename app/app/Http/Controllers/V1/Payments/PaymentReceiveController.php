<?php

namespace App\Http\Controllers\V1\Payments;


use App\Events\InvoicePaymentSuccess;
use App\Events\PayslipPaid;
use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\ReceivePayment;
use App\Models\Enums\InvoicePaymentStatus;
use App\Models\Enums\InvoiceStatus;
use App\Models\Enums\PayrunStatus;
use App\Repositories\InvoicePaymentRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\PayrunRepository;
use Carbon\Carbon;
use Exception;

class PaymentReceiveController extends Controller
{
    protected $paymentsRepository;
    protected $invoiceRepository;
    protected $payrunRepository;

    public function __construct(
        InvoicePaymentRepository $paymentRepository,
        InvoiceRepository $invoiceRepository,
        PayrunRepository $payrunRepository)
    {
        $this->middleware('jwt.auth');
        $this->paymentsRepository = $paymentRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->payrunRepository = $payrunRepository;
    }

    private function createInvoicePayment(string $id)
    {
        $invoice = $this->invoiceRepository->skipPresenter()->find($id);

        $invoice->status = InvoiceStatus::PAID;
        $invoice->save();

        $payment = $this->paymentsRepository->skipPresenter()->create([
           'invoice_id' => $invoice->id,
           'invoice_type' => get_class($invoice),
           'medium' => "offline",
           'transaction_ref' => str_random(11),
           'amount' => $invoice->total,
           'first_name' => "Bridgebooks",
           'last_name' => "Manual Payments",
            'processor_fee' => 0,
           'paid_at' => Carbon::now(),
           'status' => InvoicePaymentStatus::VERIFIED
        ]);

        event(new InvoicePaymentSuccess($invoice, $payment));

        return $payment;
    }

    private function createPayrunInvoicePayment(string $id)
    {
        $payrun = $this->payrunRepository->skipPresenter()->find($id);

        $payrun->status = PayrunStatus::PAID;
        $payrun->save();

        $payrun->payslips->each(function ($payslip) {
           $paymentAttrs =  [
               'invoice_id' => $payslip->id,
               'invoice_type' => get_class($payslip),
               'medium' => "offline",
               'transaction_ref' => str_random(11),
               'amount' => $payslip->net_pay,
               'first_name' => "Bridgebooks",
               'last_name' => "Manual Payments",
               'processor_fee' => 0,
               'paid_at' => Carbon::now(),
               'status' => InvoicePaymentStatus::VERIFIED
           ];

           $payment = $this->paymentsRepository->skipPresenter()->create($paymentAttrs);

           event(new PayslipPaid($payslip, $payment));
        });
    }

    public function handle (ReceivePayment $request)
    {
        $type = $request->input('type');
        $id = $request->input('ref');

        switch ($type) {
            case "invoice":
                $this->createInvoicePayment($id);
                break;
            case "payrun":
                $this->createPayrunInvoicePayment($id);
                break;
        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully marked paid"
        ]);
    }
}