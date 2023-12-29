<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChannelReceiveMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $receiverId;
    private Message $message;

    /**
     * Create a new event instance.
     */
    public function __construct(int $receiverId, Message $message)
    {
        $this->receiverId = $receiverId;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel('private.channel.'.$this->receiverId);
    }

    public function broadcastAs()
    {

        return 'receive.message';

    }

    public function broadcastWith(): array
    {

        return [
            'sender' => User::find($this->message['sender_id']),
            'message' => $this->message
        ];

    }
}
