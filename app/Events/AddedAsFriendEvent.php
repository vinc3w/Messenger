<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddedAsFriendEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $receiverId;
    private array $friend;

    /**
     * Create a new event instance.
     * friend parameter is array instead of User because friend parameter need the
     * channel properties which must be manually included.
     */
    public function __construct(int $receiverId, array $friend)
    {
        $this->receiverId = $receiverId;
        $this->friend = $friend;
    }
    
    public function broadcastOn()
    {
        return new PrivateChannel('private.channel.'.$this->receiverId);
    }

    public function broadcastAs()
    {

        return 'added.as.friend';

    }

    public function broadcastWith(): array
    {

        return [
            'friend' => $this->friend
        ];

    }
}
