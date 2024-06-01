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

Broadcast::channel('public.test-channel', function ($user) {
    return true;
});

Broadcast::channel('private.test-channel', function ($user) {
    return true;
});

Broadcast::channel('presence.test-channel', function ($user) {
    return $user;
});
