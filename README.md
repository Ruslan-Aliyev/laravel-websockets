# Bare basics

```
composer require beyondcode/laravel-websockets
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"

composer require pusher/pusher-php-server:7.0 -W # Can't have latest versions here
composer require react/promise:^2.3 -W
```

config/websockets.php
```
'apps' => [
    [
        'id' => env('PUSHER_APP_ID'),
        'name' => env('APP_NAME'),
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
```

.env
```
BROADCAST_DRIVER=pusher
...
QUEUE_CONNECTION=sync
...
PUSHER_APP_ID=livepost 				# just anything
PUSHER_APP_KEY=livepost_key 		# just anything
PUSHER_APP_SECRET=livepost_secret 	# just anything
# PUSHER_HOST=
# PUSHER_PORT=443
# PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1
```

config/broadcasting.php
```
'connections' => [

    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'host' => '127.0.0.1',
            'port' => 6001,
            'scheme' => 'http',
            'encrypted' => true,
            //'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
        ],
```

config/app.php
```
'providers' => [
	...
    App\Providers\BroadcastServiceProvider::class, // uncomment this
```

```
php artisan serve
php artisan websockets:serve # In another terminal
```

Visit http://localhost:8000/laravel-websockets

## Tutorials

- https://www.youtube.com/watch?v=AUlbN_xsdXg
- https://www.youtube.com/watch?v=8RL584c7EsI&list=PLWiQT7FWaG1igDILyxwi-h5gFhkXAVeWZ&index=23

### Other Tutorials

- https://beyondco.de/docs/laravel-websockets/getting-started/installation
- https://github.com/beyondcode/laravel-websockets
- https://startutorial.com/view/laravel-websockets-tutorial
- https://www.honeybadger.io/blog/a-guide-to-using-websockets-in-laravel/
- https://www.youtube.com/playlist?list=PLfdtiltiRHWGoBloQG32kmesr0EUGoYpn
- https://www.youtube.com/playlist?list=PLwAKR305CRO9rlj-U9oOi4m2sQaWN6XA8
- https://www.youtube.com/playlist?list=PLQDioScEMUhl_vDV7BcYTUdTU4Jz8g58X