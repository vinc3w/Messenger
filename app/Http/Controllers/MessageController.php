<?php

namespace App\Http\Controllers;

use App\Events\ChannelReceiveMessageEvent;
use App\Events\ReceiveMessageEvent;
use App\Events\DeleteMessageEvent;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{

    /**
     * Dispatch delete message event so the other party can delete the message
     */
    public function delete(Request $request)
    {

        event(new DeleteMessageEvent($request->channelId, $request->messageId));

    }

    /**
     * Store new message.
     */
    public function store(Request $request): JsonResponse
    {

        $messageId = DB::table('messages')->insertGetId([
            'channel_id' => $request->channelId,
            'sender_id' => $request->user()->id,
            'message' => $request->message,
            'reply_to' => $request->replyTo,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $message = Message::find($messageId);

        event(new ReceiveMessageEvent($request->channelId, $message));

        $channel = DB::table('channels')->find($request->channelId);
        $receiverId = $channel->user1_id === $request->user()->id ? $channel->user2_id : $channel->user1_id;

        event(new ChannelReceiveMessageEvent($receiverId, $message));

        return response()->json([
            'message' => $message
        ]);

    }

    /**
     * Mark all unseen messages as seen
     */
    public function update(Request $request): JsonResponse
    {

        DB::table('messages')
          ->where('channel_id', $request->channelId)
          ->where('sender_id', '!=', $request->user()->id)
          ->where('seen', false)
          ->update(['seen' => true]);

        return response()->json([
            'message' => 'All messages marked as read.'
        ]);

    }

    /**
     * Delete message.
     */
    public function destroy(Request $request, int $id)
    {

        DB::table('messages')->delete($id);
        event(new DeleteMessageEvent($request->channelId, $id));

    }
}
