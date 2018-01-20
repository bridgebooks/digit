<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrimaryUserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $trial_days;

    public $plan;

    /**
     * Create a new event instance.
     * @param User $user
     * @param int $trial_days
     * @return void
     */
    public function __construct(User $user, int $trial_days, string $plan)
    {
        $this->user = $user;
        $this->trial_days = $trial_days;
        $this->plan = $plan;
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
