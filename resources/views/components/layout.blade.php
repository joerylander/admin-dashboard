<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <header>
        <h1>Dashboard</h1>
        <nav>
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
