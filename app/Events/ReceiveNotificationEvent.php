<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReceiveNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Notification $notification;
    private int $receiverId;

    /**
     * Create a new event instance.
     */
    public function __construct(Notification $notification, int $receiverId)
    {
        $this->notification = $notification;
        $this->receiverId = $receiverId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel('private.notification.'.$this->receiverId);
    }

    public function broadcastAs(): string
    {

        return 'receive.notification';

    }

    public function broadcastWith(): array
    {
        $this->notification->receiver = User::find($this->receiverId);
        
        return [
            'notification' => $this->notification
        ];

    }
}
