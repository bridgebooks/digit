<?php

namespace App\Events;

use App\Models\Org;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrgCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $org;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Org $org)
    {
        $this->org = $org;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
