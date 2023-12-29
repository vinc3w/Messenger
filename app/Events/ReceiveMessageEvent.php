<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReceiveMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $channelId;
    private Message $message;

    /**
     * Create a new event instance.
     */
    public function __construct(int $channelId, Message $message)
    {
        $this->channelId = $channelId;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {

        return new PrivateChannel('private.chat.'.$this->channelId);

    }

    public function broadcastAs()
    {
        return 'receive.message';
    }

    public function broadcastWith(): array
    {

        return [
            'message' => $this->message
        ];

    }
}
