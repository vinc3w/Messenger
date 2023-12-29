<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $channelId;
    private int $messageId;

    /**
     * Create a new event instance.
     */
    public function __construct(int $channelId, int $messageId)
    {
        $this->channelId = $channelId;
        $this->messageId = $messageId;
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

        return 'delete.message';

    }

    public function broadcastWith(): array
    {

        return [
            'messageId' => $this->messageId
        ];

    }
}
