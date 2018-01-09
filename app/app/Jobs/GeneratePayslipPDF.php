<?php

namespace App\Jobs;

use App\Models\Payrun;
use App\Models\Payslip;
use PDF;
use View;
use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GeneratePayslipPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payrun;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Payrun $payrun)
    {
        $this->payrun = $payrun;
    }

    private function allowances(Payslip $slip)
    {
        return $slip->items->filter(function ($paySlipItem) {
            return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::ALLOWANCE;
        });
    }

    private function wages(Payslip $slip)
    {
        return $slip->items->filter(function ($paySlipItem) {
            return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::WAGES;
        });
    }

    private function reimbursments(Payslip $slip)
    {
        return $slip->items->filter(function ($paySlipItem) {
            return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::REIMBURSEMENT;
        });
    }

    private function deductions(Payslip $slip)
    {
        return $slip->items->filter(function ($paySlipItem) {
            return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::DEDUCTION;
        });
    }

    private function tax(Payslip $slip)
    {
        return $slip->items->filter(function ($paySlipItem) {
            return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::TAX;
        });
    }

    private function getSlipData(Payslip $slip)
    {
        $allowances = $this->allowances($slip);

        $wages = $this->wages($slip);

        $reimbursements = $this->reimbursments($slip);

        $deductions = $this->deductions($slip);

        $tax = $this->tax($slip);

        $earnings = $allowances->concat($wages, $reimbursements)
            ->map(function ($item) {
                return $item->amount;
            })
            ->sum();

        $less = $deductions->concat($tax)
            ->map(function ($item) {
                return $item->amount;
            })
            ->sum();

        return [
            'wages' => $wages,
            'allowances' => $allowances,
            'reimbursements' => $reimbursements,
            'deductions' => $deductions,
            'earnings' => $earnings,
            'gross_deductions' => $less,
            'slip' => $slip
        ];
    }

    private function saveSlip(string $name, $pdf)
    {
        config(['filesystems.disks.azure.container' => 'slips']);

        $name = $name.'.pdf';

        Storage::disk('azure')->put($name, $pdf->output());
        $url = Storage::disk('azure')->url($name);

        return $url;
    }

    private function makePDFs(Payrun $payrun)
    {
        $slips = $payrun->payslips;

        foreach ($slips as $slip) {
            $html = View::make('payslips.standard', $this->getSlipData($slip))->render();
            $html = preg_replace('/>\s+</', '><', $html);

            $pdf = PDF::loadHtml($html);
            $url = $this->saveSlip($slip->reference, $pdf);

            $slip->pdf_url = $url;
            $slip->save();
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payrun = $this->payrun;

        $this->makePDFs($payrun);

        // delete job from queue
        $this->delete();
    }
}
