<aside class="w-64 bg-gray-800 border-r border-gray-700 flex flex-col min-h-screen">
    <nav class="px-4 py-6">
        <section class="mb-8">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Navigation</h3>
            <ul class="space-y-1">
                <li>
                    <a href="/images"
                        class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200 {{ request()->is('benefits*') ? 'bg-blue-600 text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="flex-1">Images</span>
                    </a>
                </li>
                <li>
                    <a href="/cv"
                        class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200 {{ request()->is('benefits*') ? 'bg-blue-600 text-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="flex-1">CV</span>
                    </a>
                </li>
            </ul>
        </section>
    </nav>

    <nav class="px-4 py-6">
        <section class="mb-8">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Projects</h3>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('projects.index') }}"
                        class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="flex-1">Overview</span>
                    </a>
                </li>
            </ul>
        </section>
    </nav>
</aside>
