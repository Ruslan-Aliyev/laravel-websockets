# WebSockets in Laravel

## Basics

WS have 2 patterns: RPC and PubSub.  
This project will be using the PubSub pattern.  

Pusher and Ably are non-free hosted WS services.  
This project will use the free alternative to Pusher: `beyondcode/laravel-websockets`. It will create a local WS server.   
Note: `beyondcode/laravel-websockets` made obsolete by Reverb (which is based on ReactPHP).

The front-end will use Echo.  
Note: An alternative for Echo is Soketi.  

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

When you are using `beyondcode/laravel-websockets`, the `xxx`s can be anything, because `laravel-websockets` just uses them to identify the app in case there are many apps connected to the same WS server. (See `config/websockets.php`'s `apps` array)

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

## Channel types

- Public: Anyone without signing in can write into.
- Private: Only logged-in users can write into. The writer's identity will remain anonymous.
	- Presence: Only logged-in users can write into. The writer's identity is visible.

## Fire a public channel event

Make a new event `php artisan make:event PublicChannelEvent`, make it implement `ShouldBroadcast`. Complete this file.

Note: in `route.channels.php`'s `Broadcast::channel('App.Models.User.{id}'` must return a truthy value, for the ws-handshake to be successful.

Fire the event in an easy way: in `route.web.php`, make a route `Route::get('/test-public-channel', function () { event(new \App\Events\PublicChannelEvent()) ...`, then visit http://localhost:8000/test-public-channel

![](/Illustrations/public_event_shown_on_dashboard.png)
