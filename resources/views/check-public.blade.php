<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Check Public Channel</title>
    </head>
    <body>
        <h1>Updates List</h1>

        <ul id="updates">
        </ul>

        @vite('resources/js/app.js')
        <script>
            const list = document.getElementById("updates");

            setTimeout(() => {
                const channel = Echo.channel('public.test-channel.1');
                
                channel
                    .subscribed(() => {
                        console.log('subscribed!');
                    })
                    .listen('.PublicUpdateEvent', (e) => {
                        let li = document.createElement("li");
                        li.innerText = e.update;
                        list.append(li);
                    });
            }, 200);
        </script>
    </body>
</html>