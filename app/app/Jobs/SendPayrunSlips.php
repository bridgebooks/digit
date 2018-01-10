<?php

namespace App\Jobs;

use App\Models\Payrun;
use App\Notifications\EmployeePayslip;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPayrunSlips implements ShouldQueue
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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payslips = $this->payrun->payslips;

        foreach ($payslips as $payslip) {
            if ($payslip->employee->email) {
                $payslip
                    ->employee
                    ->notify(new EmployeePayslip($payslip));
            }
        }
    }
}
