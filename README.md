# WebSockets in Laravel

## Basics

WS have 2 patterns: RPC and PubSub.  
This project will be using the PubSub pattern.  

[Pusher](https://pusher.com) and [Ably](https://ably.com) are non-free hosted WS services.  
This project will use the free alternative to Pusher: `beyondcode/laravel-websockets`. It will create a local WS server.   
Note: [`laravel-websockets`](https://github.com/beyondcode/laravel-websockets) made obsolete by [Reverb](https://reverb.laravel.com) (which is based on [ReactPHP](https://reactphp.org)).

The front-end will use [Echo](https://www.npmjs.com/package/laravel-echo).  
Note: An alternative for Echo is [Soketi](https://www.npmjs.com/package/@soketi/soketi).  

## Setup

```
composer require beyondcode/laravel-websockets
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider"
php artisan migrate
```

This will make the file `config/websockets.php` and the DB table `websockets_statistics_entries`

Set `.env`'s `QUEUE_CONNECTION=sync`, just for simplicity.

![](/Illustrations/queue.png)

In `config.app.php`, uncomment `App\Providers\BroadcastServiceProvider`, in order to be able to broadcast.

Set `.env`'s `BROADCAST_DRIVER=pusher`

Since we are not using the hosted Pusher service, we shall make the `.env` like below:

```
PUSHER_APP_ID=xxx
PUSHER_APP_KEY=xxx
PUSHER_APP_SECRET=xxx
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001 # laravel-websocket's local WS server serves on port 6001, as seen in config/websockets.php
PUSHER_SCHEME=http
```

When you are using `laravel-websockets`, the `xxx`s can be anything, because `laravel-websockets` just uses them to identify the app in case there are many apps connected to the same WS server. (See `config/websockets.php`'s `apps` array)

But if you are really using the Pusher server, then they should be the APP keys and secrets, which is obtained from https://dashboard.pusher.com/apps/{app_id}/keys    
The host wouldn't be local neither; port should be `443` & scheme should be `https`.   

These env vars will affect  `config/broadcasting.php`    
Furthermore, `encrypted` will also need to be false:
```php
'connections' => [
    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'host' => env('PUSHER_HOST') ?: 'api-'.env('PUSHER_APP_CLUSTER', 'mt1').'.pusher.com',
            'port' => env('PUSHER_PORT', 443),
            'scheme' => env('PUSHER_SCHEME', 'https'),
            'encrypted' => false, // <-- encrypted should be false for local WS server
            'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
        ],
```

If you don't tweek like above, the local WS server can still run, but you won't be able to send any messages to the right place, as it will try to send them up to a phamtom hosted Pusher server.

Run:
```
php artisan serve
php artisan websockets:serve # In another terminal
```

Visit http://localhost:8000/laravel-websockets

![](/Illustrations/local_ws_server.png)

If you are really using the Pusher server, the dashboard is here https://dashboard.pusher.com/apps/{app_id}/console

Relevant commit: https://github.com/Ruslan-Aliyev/laravel-websockets/commit/d8871385871382ce4bdb4b79d33595cc50c22096

## Channel types

- Public: Anyone without signing in can write into.
- Private: Only logged-in users can write into. The writer's identity will remain anonymous.
	- Presence: Only logged-in users can write into. The writer's identity is visible.

## Fire a public channel event

Make a new event `php artisan make:event PublicChannelEvent`, make it implement `ShouldBroadcast`. Complete this file.

Note: in `route.channels.php`'s `Broadcast::channel('App.Models.User.{id}'` must return a truthy value, for the ws-handshake to be successful.

Fire the event in an easy way: in `route.web.php`, make a route `Route::get('/test-public-channel', function () { event(new \App\Events\PublicChannelEvent()) ...`, then visit http://localhost:8000/test-public-channel

![](/Illustrations/public_event_shown_on_dashboard.png)

Relevant commit: https://github.com/Ruslan-Aliyev/laravel-websockets/commit/f1fccc15363e00b92ef7ef166292bda6de4344e3

## Receiving a public channel event

`npm install laravel-echo pusher-js`

[`pusher-js`](https://www.npmjs.com/package/pusher-js): Implements the Pusher API

[`laravel-echo`](https://www.npmjs.com/package/laravel-echo): A wrapper around the `pusher-js`, tailored to receive broadcasts from Laravel. It's a single-style wrapper that supports multiple drivers (eg: whether it's `pusher-js` or `socket.io`). The nice thing about using `Echo` is the ability to easily swap drivers, ie: if you start with `Pusher` free, then later decide to use `Reverb` or `Soketi`, you only need to update a bit of config.

Configure `Echo` in `resources/js/bootstrap.js`

Make a blade file: `check-public.blade.php`

Create a route to serve this view in `route/web.php`: 
```php
Route::get('/check-public-channel', function () {
    return view('check-public');
});
```

Run:
```
php artisan serve
php artisan websockets:serve # In another terminal
npm run dev # In another terminal
```

![](/Illustrations/public_event_received_on_frontend.png)

Relevant commit: https://github.com/Ruslan-Aliyev/laravel-websockets/commit/0ccfd5fcc32f2a23c8c7df4036de4175c248f6e7

## After some refinements to the public channel

![](/Illustrations/public_channel_refined.png)

Relevant commit: https://github.com/Ruslan-Aliyev/laravel-websockets/commit/b67c44704c782d1342e99708eec4c5146c8072a2

## Private Channels

Install Laravel Breeze for Auth: https://laravel.com/docs/11.x/starter-kits#laravel-breeze-installation

Create some users. Easy ways include Tinker or Factory.

Create the routes, controller, event, channel and blade files for sending and receiving messages on the private channel

![](/Illustrations/private_channel_in_action.png)

Relevant commit: https://github.com/Ruslan-Aliyev/laravel-websockets/commit/b88960cd3ca723d9554f11bbcefb724e6051cde1

## Presence Channels

See the routes, controller, event, channel and blade files for sending and receiving messages on the presence channel

![](/Illustrations/presence_channel_chat.png)

---

# Tutorials

- https://www.youtube.com/watch?v=AUlbN_xsdXg (Very Good)
- https://www.youtube.com/watch?v=8RL584c7EsI&list=PLWiQT7FWaG1igDILyxwi-h5gFhkXAVeWZ&index=23
- https://www.youtube.com/watch?v=CkRGJC0ytdU

## Other Tutorials

- https://beyondco.de/docs/laravel-websockets/getting-started/installation
- https://github.com/beyondcode/laravel-websockets
- https://startutorial.com/view/laravel-websockets-tutorial
- https://www.honeybadger.io/blog/a-guide-to-using-websockets-in-laravel/
- https://www.youtube.com/playlist?list=PLfdtiltiRHWGoBloQG32kmesr0EUGoYpn
- https://www.youtube.com/playlist?list=PLwAKR305CRO9rlj-U9oOi4m2sQaWN6XA8
- https://www.youtube.com/playlist?list=PLQDioScEMUhl_vDV7BcYTUdTU4Jz8g58X
- https://www.youtube.com/watch?v=pIGy7-7gGXI
- https://www.youtube.com/watch?v=qdhnC_FUBbs
- https://www.youtube.com/watch?v=LU3fkcUyCVA
- https://www.youtube.com/watch?v=YCK8JwDJI5s
- https://www.youtube.com/watch?v=XgFzHXOk8IQ (long)
