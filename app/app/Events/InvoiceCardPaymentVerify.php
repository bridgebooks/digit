<?php

namespace App\Events;

use App\Repositories\InvoicePaymentRepository;
use App\Models\Invoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InvoiceCardPaymentVerify
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice;
    public $response;
    public $repository;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, $response)
    {
        $this->invoice = $invoice;
        $this->response = $response;
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
