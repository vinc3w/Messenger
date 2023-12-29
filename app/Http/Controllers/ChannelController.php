<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ChannelController extends Controller
{
    /**
     * Get channel properties and messages
     * channelId set to type of mixed instead of int
     * because if set to int, it will only allowed int value, others will throw an error
     */
    public function show(Request $request, mixed $channelId): JsonResponse
    {

        $channel = DB::table('channels')->where('id', $channelId)->first();

        if (!$channel) {
            return response()->json([
                'channel' => null
            ]);
        }

        $receiverId = $request->user()->id === $channel->user1_id ? $channel->user2_id : $channel->user1_id;

        $channel->messages = Message::where('channel_id', $channelId)->get();
        $channel->receiver = DB::table('users')
            ->where('id', $receiverId)
            ->first(['name', 'profile_image']);
        $channel->receiver->is_online = Cache::has('is-user-online-'.$receiverId);

        return response()->json([
            'channel' => $channel
        ]);

    }

}
