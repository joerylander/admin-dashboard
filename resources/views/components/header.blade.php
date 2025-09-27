<!-- Top Bar -->
<header class="bg-gray-900 border-b border-gray-700 px-6 py-4 flex items-center justify-between w-full">
    <h1 class="text-xl font-bold text-white">
        <a href="/">
            Dashboard
        </a>
    </h1>

    <div class="flex-1 max-w-md mx-4">
        <input type="text" placeholder="Search tools..."
            class="w-full px-4 py-2 bg-gray-800 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <div class="flex items-center space-x-4">
        <a href="{{ route('show.login') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">Login</a>
    </div>
</header>
