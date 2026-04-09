<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="HA Tech The Gen Z Hustler - Professional portfolio generator for students.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HA Tech Portfolio Generator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden w-full">
    <div id="app"></div>
</body>
</html>
