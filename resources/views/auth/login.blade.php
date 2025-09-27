    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign in</title>
        @vite('resources/css/app.css')
    </head>

    <body class="bg-gray-900">
        <x-messages.errors />

        <div class="flex items-center justify-center min-h-svh">
            <main class="w-full max-w-md mx-auto px-6">
                <!-- Login Card -->
                <article class="bg-gray-800 border border-gray-400 rounded-lg p-8 shadow-2xl">
                    <!-- Header -->
                    <header class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-white mb-2">Admin Login</h1>
                        <p class="text-gray-300 text-sm">Sign in to access your dashboard</p>
                    </header>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        <fieldset class="space-y-6">
                            <legend class="sr-only">Login Credentials</legend>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                                    Email Address
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter email" required autocomplete="email" autofocus
                                    class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-all duration-200"
                                    aria-describedby="@error('email') email-error @enderror">
                                @error('email')
                                    <p id="email-error" class="text-red-400 text-sm mt-1" role="alert">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                                    Password
                                </label>
                                <input type="password" id="password" name="password" placeholder="Enter password"
                                    required
                                    class="w-full px-3 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-all duration-200"
                                    aria-describedby="@error('password') password-error @enderror">
                                @error('password')
                                    <p id="password-error" class="text-red-400 text-sm mt-1" role="alert">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <input type="checkbox" id="remember" name="remember"
                                    class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="ml-2 text-sm text-gray-300">
                                    Keep me signed in
                                </label>
                            </div>
                        </fieldset>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full mt-8 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all duration-200 active:transform active:scale-[0.98]">
                            Sign In
                        </button>
                    </form>
                </article>
            </main>
        </div>

    </body>

    </html>
