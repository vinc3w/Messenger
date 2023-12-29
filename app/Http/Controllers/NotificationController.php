<?php

namespace App\Http\Controllers;

use App\Events\ReceiveNotificationEvent;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    /**
     * Get all user's notification.
     */
    public function index(Request $request): JsonResponse
    {

        $notifications = $request->user()->notifications;

        foreach($notifications as $n) {
            $n->receiver = User::find($n->sender_id);
        }

        return response()->json([
            'notifications' => $notifications
        ]);

    }

    /**
     * Store new notification
     */
    public function store(Request $request): JsonResponse
    {

        $notificationId = DB::table('notifications')->insertGetId([
            'receiver_id' => $request->receiverId,
            'sender_id' => $request->user()->id,
            'message' => $request->user()->name.' has added you as friend.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        $notification = Notification::find($notificationId);

        event(new ReceiveNotificationEvent($notification, $request->receiverId));

        return response()->json([
            'notification' => $notification
        ]);

    }

    /**
     * Remove notification.
     */
    public function destroy(Notification $notification): JsonResponse
    {
        
        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted'
        ]);

    }
}
