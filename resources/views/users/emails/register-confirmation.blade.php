<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <p>Hello {{ $name }}</p>
    <p>Thank you for registering.</p>
    <p>To start, please access the website <a href="{{ $app_url }}" class="">here.</a></p>
    {{-- $name & $app_url : from register controller($details) --}}
</body>
</html>
