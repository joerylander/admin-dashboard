<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    @vite('resources/css/app.css')
</head>

<body>
    <div class="min-h-screen bg-[#0a0a0a] text-[#ededed]">
        <x-header />

        <div class="flex">
            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content -->
            <main class="flex-1 flex flex-col p-8">
                <x-messages.success />
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

<script>
    // Close modals if clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('bg-black')) {
            event.target.classList.add('hidden');
            event.target.style.display = 'none';
        }
    });
</script>

</html>
