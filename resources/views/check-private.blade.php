<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Check Private Channel</title>
    </head>
    <body>
        <h1>Message List</h1>

        <ul id="messages">
        </ul>

        @vite('resources/js/app.js')
        <script>
            const messages = document.getElementById("messages");

            setTimeout(() => {
                const channel = Echo.private('private.test-channel.1');
                
                channel
                    .subscribed(() => {
                        console.log('subscribed!');
                    })
                    .listen('.PrivateMessageEvent', (e) => {
                        let li = document.createElement("li");
                        li.innerText = e.message;
                        messages.append(li);
                    });
            }, 200);
        </script>
    </body>
</html>