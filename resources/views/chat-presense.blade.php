<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Chat on Presence Channel</title>
    </head>
    <body>
        <h1>Chat</h1>
        
        <input type="text" name="message" id="message" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrf">
        <button onclick="sendMessage()">Send</button>

        <ul id="chat">
        </ul>

        <script>
            function sendMessage() {
                const ACTION_URL = {!! json_encode(url('/presence-channel-chat')) !!};
                const formData = new FormData();
                formData.append('message', document.getElementById('message').value);
                formData.append('_token', document.getElementById('csrf').value);
                fetch(ACTION_URL, {method:'post', body: formData});

                document.getElementById('message').value = '';
            }
        </script>

        @vite('resources/js/app.js')
        <script>
            const chat = document.getElementById("chat");

            setTimeout(() => {
                const channel = Echo.join('presence.test-channel');
                
                channel
                    .subscribed(() => {
                        console.log('subscribed!');
                    })
                    .listen('.PresenceChatEvent', (e) => {
                        let li = document.createElement("li");
                        li.innerText = `${e.sender}: ${e.message}`;
                        chat.append(li);
                    });
            }, 200);
        </script>
    </body>
</html>