<!-- Top Bar -->
<header class="bg-gray-900 border-b border-gray-700 px-6 py-4 flex items-center justify-between w-full">
    <div class="flex items-center space-x-4">
        @auth
            <h1 class="text-xl font-bold text-white">
                <a href="/" class="hover:text-blue-400 transition-colors duration-200">
                    Dashboard
                </a>
            </h1>
            <span class="text-gray-400">|</span>
            <h3 class="text-gray-300">
                Welcome, {{ ucfirst(Auth::user()->name) }}
            </h3>
        @endauth
    </div>

    @auth
        <div class="flex-1 max-w-md mx-8">
            <input type="text" placeholder="Search tools..."
                class="w-full px-4 py-2 bg-gray-800 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    @endauth

    <div class="flex items-center space-x-4">
        @guest
            <a href="{{ route('show.login') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                Login
            </a>
        @endguest

        @auth
            <form action="{{ route('logout') }}" method="post" class="inline">
                @csrf
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 font-medium">
                    Logout
                </button>
            </form>
        @endauth
    </div>
</header>
