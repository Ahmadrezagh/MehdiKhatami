<?php

namespace App\Events;

use App\Http\Resources\SignalResource;
use App\Models\Signal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignalSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $signal;

    /**
     * Create a new event instance.
     *
     * @param Signal $signal
     */
    public function __construct(Signal $signal)
    {
        $this->signal = new SignalResource($signal);
    }

    public function broadcastOn()
    {
        return ['Signal'];
    }
}
