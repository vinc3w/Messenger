<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RemovedAsFriendEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $receiverId;
    private int $channelId;

    /**
     * Create a new event instance.
     */
    public function __construct(int $receiverId, int $channelId)
    {
        $this->receiverId = $receiverId;
        $this->channelId = $channelId;
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

        return 'removed.as.friend';

    }

    public function broadcastWith(): array
    {

        $channel = DB::table('channels')->find($this->channelId);
        $allMessages = DB::table('messages')
                         ->where('channel_id', $this->channelId)
                         ->where('sender_id', '!=', $this->receiverId)
                         ->get()
                         ->toArray();
        $channel->newMessageCount = 0;
        foreach ($allMessages as $m) {
            $channel->newMessageCount += $m->seen ? 0 : 1;
        }

        return [
            'channel' => $channel,
        ];

    }
}
