<x-app-layout title="Login">
    <div class="flex items-center justify-center min-h-screen bg-gray-900">
        <div class="w-full max-w-md p-6 bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center text-gray-100">Login</h2>
            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="block w-full px-4 py-2 border border-gray-700 rounded-md text-gray-100 bg-gray-700 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="block w-full px-4 py-2 border border-gray-700 rounded-md text-gray-100 bg-gray-700 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember_token"
                        class="h-4 w-4 text-blue-600 border-gray-700 rounded focus:ring-blue-600 bg-gray-700">
                    <label for="remember" class="ml-2 text-sm text-gray-300">Remember me</label>
                </div>

                <!-- Submit -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-500">
                        Login
                    </button>
                </div>
            </form>

            <p class="mt-6 text-sm text-center text-gray-400">
                Don't have an account? <a href="{{ route('register') }}" class="text-blue-400 hover:underline">Register</a>
            </p>
        </div>
    </div>
</x-app-layout>
