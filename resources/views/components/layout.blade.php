<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    @vite('resources/css/app.css')
</head>

<body>
    <header>
        <nav>
            <h1>
                <a href="/">
                    Dashboard
                </a>
            </h1>
            <a href="/ninjas">
                All Ninjas
            </a>

            <a href="/ninjas/create">
                Create new Ninja
            </a>
        </nav>
    </header>

    <main class="container">
        {{ $slot }}
    </main>

</body>

</html>
