<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class RealTimeMessage implements ShouldBroadcast
{
    use SerializesModels;

    public string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function broadcastAs(): string
    {
        return 'RealTimeMessage';
    }

    public function broadcastWith(): array
    {
        return [
            'message'=> $this->message,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('events')
        ];
    }
}
