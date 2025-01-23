<?php

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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('community-feed', function ($data) {
    return true;
});

Broadcast::channel('comment-channel', function ($data) {
    return true;
});
Broadcast::channel('like-channel', function ($data) {
    return true;
});
Broadcast::channel('post-notification-channel', function ($data) {
    return true;
});
Broadcast::channel('post-delete-channel', function ($data) {
    return true;
});

