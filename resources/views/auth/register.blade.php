<x-app-layout title="Register">
    <div class="flex items-center justify-center min-h-screen bg-gray-900">
        <div class="w-full max-w-md p-6 bg-gray-800 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center text-gray-100">Register</h2>
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="block w-full px-4 py-2 border border-gray-700 rounded-md text-gray-100 bg-gray-700 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                </div>

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

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="block w-full px-4 py-2 border border-gray-700 rounded-md text-gray-100 bg-gray-700 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                </div>

                <!-- Profile Picture -->
                <div>
                    <label for="profile_picture" class="block text-sm font-medium text-gray-300 mb-1">Profile Picture (optional)</label>
                    <input type="file" id="profile_picture" name="profile_picture"
                        class="block w-full text-gray-300 bg-gray-700 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                </div>

                <!-- Submit -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-500">
                        Register
                    </button>
                </div>
            </form>

            <p class="mt-6 text-sm text-center text-gray-400">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Login</a>
            </p>
        </div>
    </div>
</x-app-layout>
