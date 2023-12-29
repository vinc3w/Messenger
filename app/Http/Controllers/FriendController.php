<?php

namespace App\Http\Controllers;

use App\Events\AddedAsFriendEvent;
use App\Events\RemovedAsFriendEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{

    /**
     * Get list of user's friends
     */
    private function getFriends(User $user)
    {

        $tempFriends = $user->friends->toArray();
        $friends = [];

        for ($i = 0; $i < sizeof($tempFriends); $i++) {
            $allMessages = DB::table('messages')
                             ->where('channel_id', $tempFriends[$i]['channel']['id'])
                             ->where('sender_id', '!=', $user->id)
                             ->get()
                             ->toArray();
            $tempFriends[$i]['channel']['newMessageCount'] = 0;
            foreach ($allMessages as $m) {
                $tempFriends[$i]['channel']['newMessageCount'] += $m->seen ? 0 : 1;
            }
            $tempFriends[$i]['channel']['lastMessage'] = DB::table('messages')
                                                       ->where('channel_id', $tempFriends[$i]['channel']['id'])
                                                       ->latest()
                                                       ->first(['sender_id', 'message']);
            $friends[$tempFriends[$i]['id']] = $tempFriends[$i];
        }

        return $friends;

    }

    /**
     * Get list of user's friends
     */
	public function index(Request $request): JsonResponse
	{

        return response()->json([
            'friends' => array_values($this->getFriends($request->user()))
        ]);

	}
	
	/**
	 * Store new friend relationship.
	 */
    public function store(Request $request): JsonResponse
    {

        $user = $request->user();
        $userId = $user->id;
        $friendId = $request->input('friendId');
        $friend = User::find($friendId);

        /*
        |--------------------------------------------------------------------------
        | Validation Start
        |--------------------------------------------------------------------------
        */
        if (!$friend) {
            return response()->json([
                'error' => 'User with id <'.$friendId.'> does not exist.'
            ]);
        }

        if ($friendId == $userId) {
            return response()->json([
                'error' => 'You can\'t friend yourself, silly :('
            ]);
        }

        $alreadIsFriend = sizeof(
            DB::table('channels')
                ->orWhere(function (Builder $query) use ($userId, $friendId) {
                    $query->where('user1_id', $userId)
                        ->where('user2_id', $friendId);
                })
                ->orWhere(function (Builder $query) use ($userId, $friendId) {
                    $query->where('user2_id', $userId)
                        ->where('user1_id', $friendId);
                })
                ->get()
                ->toArray()
        ) != 0;

        if ($alreadIsFriend) {
            return response()->json([
                'error' => 'You are already friend with '.$friend->name
            ]);
        }
        /*
        |--------------------------------------------------------------------------
        | Validation End
        |--------------------------------------------------------------------------
        */

        $channelId = DB::table('channels')->insertGetId([
            'user1_id' => $userId,
            'user2_id' => $friendId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $friend->channel = DB::table('channels')->find($channelId);

        event(new AddedAsFriendEvent($friendId, $this->getFriends($friend)[$userId]));

        return response()->json([
            'friend' => $this->getFriends($user)[$friendId]
        ]);

    }

	/**
	 * Unfriend friend.
	 */
	public function destroy(Request $request, string $id)
	{

        event(new RemovedAsFriendEvent($request->receiverId, $id));
		DB::table('channels')->delete($id);

	}
}
