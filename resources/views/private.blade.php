<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Listen</title>
    </head>
    <body>
        <p>{{ Auth::id() }}</p>
        @vite('resources/js/app.js')
        <script>
            setTimeout(() => {
                const channel = Echo.private('private.test-channel.user.{{ Auth::id() }}');
                
                channel
                    .subscribed(() => {
                        console.log('subscribed!');
                    })
                    .listen('.CustomPrivateEventName', (e) => {
                        console.log(e);
                    });
            }, 200);
        </script>
    </body>
</html>
