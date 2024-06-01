<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test Private Channel</title>
    </head>
    <body>
		<h1>Send some messages</h1>

		<form method="POST" action="{{ route('test-private-channel') }}">
			<input type="text" name="message" />
			@csrf
			<input type="submit" value="Send" />
		</form>
    </body>
</html>