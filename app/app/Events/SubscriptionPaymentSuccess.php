<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SubscriptionPaymentSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;

    public $authorization;

    public $planCode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $email,  array $authorization, string $planCode)
    {
        $this->email = $email;
        $this->authorization = $authorization;
        $this->planCode = $planCode;
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
