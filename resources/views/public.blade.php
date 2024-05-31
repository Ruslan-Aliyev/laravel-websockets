<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Listen</title>
    </head>
    <body>
        @vite('resources/js/app.js')
        <script>
            setTimeout(() => {
                const channel = Echo.channel('public.test-channel.1');
                
                channel
                    .subscribed(() => {
                        console.log('subscribed!');
                    })
                    .listen('.CustomEventName', (e) => {
                        console.log(e);
                    });
            }, 200);
        </script>
    </body>
</html>