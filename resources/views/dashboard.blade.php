<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="text-center px-8 py-12 mx-auto">
    <h1>Welcome to your new Admin Dashboard</h1>
    <p>Click below for more info</p>
    <a href="/ninjas" class="btn mt-4 inline-block">
        Ninjas
    </a>
</body>

</html>
