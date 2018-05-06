<?php

namespace App\Events;

use App\Models\InvoicePayment;
use App\Models\Payslip;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PayslipPaid
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payslip;
    public $payment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Payslip $payslip, InvoicePayment $payment)
    {
        $this->payslip = $payslip;
        $this->payment = $payment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
