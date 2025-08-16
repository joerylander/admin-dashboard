<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    @vite('resources/css/app.css')
</head>

<body>
    @if (session('success'))
        <div id="flash" class="p-4 text-center bg-green-50 text-green-500 font-bold">
            {{ session('success') }}
        </div>
    @endif

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

    <main class="container p-6">
        {{ $slot }}
    </main>

    <script>
        // Auto-hide flash messages after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.getElementById('flash');
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.transition = 'opacity 0.5s ease-out';
                    flashMessage.style.opacity = '0';
                    setTimeout(function() {
                        flashMessage.remove();
                    }, 500); // Remove after fade out completes
                }, 3000); // Hide after 3 seconds
            }
        });
    </script>

</body>

</html>
