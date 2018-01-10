<?php

namespace App\Mail;

use App\Models\Payslip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeePayslip extends Mailable
{
    use Queueable, SerializesModels;

    public $slip;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Payslip $slip)
    {
        $this->slip = $slip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachment = file_get_contents($this->slip->pdf_url);
        $fullName = $this->slip->employee->first_name.' '.$this->slip->employee->last_name;
        $reference = $this->slip->reference;

        $name = sprintf('Payslip for %s (%s)', $fullName, $reference);
        $name .= '.pdf';
        $slip = $this->slip;

        $orgName = $this->slip->payrun->org->name;

        return $this->view('emails.payroll.payslip')
            ->from('messaging@bridgebooks.com.ng', $orgName)
            ->subject(sprintf('Payslip for %s (%s)', $fullName, $reference))
            ->with([
                'slip' => $slip
            ])
            ->attachData($attachment, $name, [
                'mime' => 'application/pdf'
            ]);
    }
}
