<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Todo List App' }}</title>

    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body class="h-full flex flex-col">

    <!-- Navbar -->
    <header class="bg-black dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <!-- Logo -->
                    <a href="{{ route('tasks.index') }}" class="text-2xl font-extrabold text-white dark:text-gray-100 hover:text-indigo-500 transition duration-200">
                        Todo App
                    </a>
                </div>
                <!-- Navigation -->
                <div class="flex items-center space-x-6">
                    @auth
                        @unless (Auth::user()->is_premium)
                            <form method="POST" action="{{ route('upgrade.premium') }}">
                                @csrf
                                <button class="px-4 py-2 bg-yellow-500 text-white rounded">Upgrade to Premium</button>
                            </form>
                        @endunless
                        <div class="flex items-center space-x-4">
                            <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                                @csrf
                                <button class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-full transition duration-300">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="text-white hover:text-indigo-500 transition duration-200">Login</a>
                        <a href="{{ route('register') }}" class="text-white hover:text-indigo-500 transition duration-200">Register</a>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow bg-gray-900 dark:bg-gray-900">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-black dark:bg-gray-800 shadow-lg mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-500 dark:text-gray-400">
            <span>&copy; {{ date('Y') }} Todo List App. All rights reserved.</span>
        </div>
    </footer>

</body>
</html>
