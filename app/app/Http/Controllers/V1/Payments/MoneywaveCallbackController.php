<?php

namespace App\Http\Controllers\V1\Payments;

use App\Events\InvoiceCardPaymentSuccess;
use App\Http\Controllers\V1\Controller;
use App\Models\Enums\InvoicePaymentStatus;
use App\Models\Enums\InvoiceStatus;
use App\Repositories\InvoicePaymentRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MoneywaveCallbackController extends Controller
{
    protected $paymentRepository;

    public function __construct(InvoicePaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function handle(Request $request)
    {
        $responseCode = $request->input('rc');
        $responseStatus = $request->input('transactionStatus');
        $reference = $request->input('ref');

        $passingResponseCodes = ['0', '00', 'RR-00'];

        $payment = $this->paymentRepository->skipPresenter()->with(['invoice'])->findWhere([
            'processor_transaction_ref' => $reference
        ]);
        $invoice = $payment->invoice;
        // redirect url
        $url = config('app.frontend_url').'/invoice-viewer/'.$invoice->id;


        if ($responseStatus == 'success' && in_array($passingResponseCodes, $responseCode)) {
            // update payment
            $payment->status = InvoicePaymentStatus::VERIFIED;
            $payment->paid_at = new Carbon();
            $payment->save();
            // update invoice
            $invoice->status = InvoiceStatus::PAID;
            $invoice->save();

            event(new InvoiceCardPaymentSuccess($invoice, $payment));
        } else {
            // update payment
            $payment->status = InvoicePaymentStatus::FAILED;
            $payment->save();
            $response = $responseStatus ?? 'Unable to validate card at this time.';

            $url .= '?responseMessage='.$response.'&status=fail';
        }

        // redirect to invoice page
        return redirect()->to($url);
    }
}