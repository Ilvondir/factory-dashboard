<?php

namespace App\Events;

use App\Models\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLogEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Log $log;

    /**
     * Create a new event instance.
     */
    public function __construct($log)
    {
        $this->log = $log;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('logs'),
        ];
    }

    public function broadcastAs()
    {
        return "NewLog";
    }

    public function broadcastWith()
    {
        return [
            "log" => $this->log,
        ];
    }
}
