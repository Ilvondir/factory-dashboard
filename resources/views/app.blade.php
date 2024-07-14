<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    @vite('resources/js/app.ts')
    @inertiaHead
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    <link rel="icon" type="image/x-icon" href="{{ asset("icon.ico") }}"> <!-- Icon from https://www.freepik.com -->
</head>
<body>
@inertia
</body>
</html>
