<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function (User $user, int $id) {

    return $user->id === $id;

});

Broadcast::channel('private.chat.{channelId}', function () {

    return true;

});

Broadcast::channel('private.notification.{receiverId}', function () {

    return true;

});

Broadcast::channel('private.channel.{receiverId}', function () {

    return true;

});
