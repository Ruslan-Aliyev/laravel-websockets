<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test Public Channel</title>
    </head>
    <body>
		<h1>Send some updates</h1>

		<form method="POST" action="{{ route('test-public-channel') }}">
			<input type="text" name="update" />
			@csrf
			<input type="submit" value="Update" />
		</form>
    </body>
</html>