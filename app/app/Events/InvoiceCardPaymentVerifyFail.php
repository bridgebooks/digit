<?php

namespace App\Events;

use App\Models\Invoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InvoiceCardPaymentVerifyFail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoice;
    public $params;
    public $response;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, array $params, $response)
    {
        $this->invoice = $invoice;
        $this->params = $params;
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
