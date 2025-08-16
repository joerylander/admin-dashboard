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
                <a href="/dashboard">
                    Dashboard
                </a>
            </h1>
            <a href="{{ route('benefits.index') }}">
                Benefits
            </a>
        </nav>
    </header>

    <x-success-message />

    <main class="container p-6">
        {{ $slot }}
    </main>

</body>

</html>
