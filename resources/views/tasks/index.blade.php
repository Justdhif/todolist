<x-app-layout title="Tasks">
    @if (session('success'))
        <div id="alert" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg z-50">
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alert = document.getElementById('alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0'; // Ubah transparansi menjadi 0
                    setTimeout(() => alert.remove(), 500); // Hapus elemen setelah animasi selesai
                }, 3000); // 5 detik sebelum menghilang
            }
        });
    </script>

    <div class="container mx-auto px-4 py-6">
        <!-- Greet -->
        <div class="flex justify-between items-center bg-gray-900 border border-gray-700 p-6 mb-6 rounded-lg relative">
            <div class="flex items-start space-x-4">
                <img src="{{ asset('storage/' . (Auth::user()->profile_picture ?? 'profile_pictures/default.jpg')) }}"
                    class="w-10 h-10 rounded-full ring-2 ring-indigo-500"
                    alt="User">
                <span class="text-white text-xl font-bold">{{ Auth::user()->name }}
                    @if (Auth::user()->is_premium)
                        <!-- Tampilkan badge di halaman profil -->
                        <span class="mt-2 ml-3 inline-block px-3 py-1 text-sm font-semibold text-yellow-500 bg-yellow-100 rounded-full">
                            <i class="fa-solid fa-crown"></i>
                        </span>
                    @endif

                </span>
            </div>
            <button class="text-white text-2xl">
                <i class="fas fa-bell"></i>
            </button>

            <!-- Notification Content -->
            <div class="absolute top-20 right-0 w-64 bg-gray-800 border border-gray-700 text-white rounded-md p-4 shadow-lg opacity-0 hover:opacity-100 transition-opacity duration-300"
                id="notification-content">
                <h4 class="text-lg font-semibold mb-2">Upcoming Task Due Dates</h4>
                <ul class="space-y-2">
                    @foreach ($tasks as $task)
                        @php
                            $dueDate = \Carbon\Carbon::parse($task->due_date);
                            $daysRemaining = $dueDate->diffInDays(now());
                        @endphp

                        @if ($daysRemaining <= 3 && $task->status == 0)
                            <li class="flex justify-between items-center">
                                <span>{{ $task->name }}</span>
                                <span class="text-red-400 text-sm">Due in {{ $daysRemaining }} days</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <script>
            const notificationIcon = document.querySelector('.fa-bell');
            const notificationContent = document.getElementById('notification-content');

            notificationIcon.addEventListener('mouseenter', () => {
                notificationContent.style.opacity = '1';
            });

            notificationIcon.addEventListener('mouseleave', () => {
                notificationContent.style.opacity = '0';
            });
        </script>

        <!-- Add Task Form -->
        <div class="bg-gray-900 shadow-lg rounded-lg p-6 mb-6 border border-gray-700">
            <h2 class="text-2xl font-semibold mb-4 text-white">Add New Task</h2>
            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf

                <div class="flex flex-wrap justify-between items-center gap-3 mb-5">
                    <!-- Task Name -->
                    <div class="w-full sm:w-full lg:w-1/4">
                        <label for="name" class="block text-sm font-medium text-gray-400 mb-3">Task Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter task name" required
                            class="w-full px-4 py-2 bg-gray-800 border border-yellow-200 text-white rounded-md focus:ring-2 focus:ring-blue-300 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="w-full sm:w-full lg:w-1/4">
                        <label for="due_date" class="block text-sm font-medium text-gray-400 mb-3">Due Date</label>
                        <input type="date" id="due_date" name="due_date" required
                            class="w-full px-4 py-2 bg-gray-800 border border-yellow-200 text-white rounded-md focus:ring-2 focus:ring-blue-600 @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Task Status -->
                    <div class="w-full sm:w-full lg:w-1/4">
                        <label for="status" class="block text-sm font-medium text-gray-400 mb-3">Status</label>
                        <select id="status" name="status"
                            class="w-full px-4 py-2 bg-gray-800 border border-yellow-200 text-white rounded-md focus:ring-2 focus:ring-blue-600">
                            <option value="0">Pending</option>
                            <option value="1">Completed</option>
                        </select>
                    </div>

                    <!-- Task Color -->
                    <div class="w-full sm:w-full lg:w-1/4">
                        <label for="color" class="block text-sm font-medium text-gray-400 mb-3">Select Color</label>
                        <input type="color" id="color" name="color" value="#ffffff"
                            class="w-full h-10 px-4 py-2 bg-gray-800 border border-yellow-200 rounded-md focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 text-white bg-purple-700 rounded-md hover:bg-purple-400 transition-all">
                        Add Task
                    </button>
                </div>

                @if (session('error'))
                    <div class="text-red-500">{{ session('error') }}</div>
                @endif
            </form>
        </div>

        <!-- Search Form -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Tasks</h1>
            <form method="GET" action="{{ route('tasks.index') }}" class="flex space-x-4">
                <input type="text" name="search" placeholder="Search tasks..." value="{{ request('search') }}"
                    class="px-4 py-2 bg-gray-800 border border-gray-700 text-white rounded-md focus:ring-2 focus:ring-blue-600 w-full sm:w-auto">
                <button type="submit"
                    class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">
                    Search
                </button>
            </form>
        </div>

        <!-- Filter and Sort -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-x-4 sm:space-y-0 flex-wrap">
            <form method="GET" action="{{ route('tasks.index') }}" class="flex space-x-4">
                <select name="status" onchange="this.form.submit()"
                    class="px-4 py-2 bg-gray-800 border border-gray-700 text-white rounded-md focus:ring-2 focus:ring-blue-600">
                    <option value="">All</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>

                <select name="sort_by" onchange="this.form.submit()"
                    class="px-4 py-2 bg-gray-800 border border-gray-700 text-white rounded-md focus:ring-2 focus:ring-blue-600">
                    <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Name</option>
                    <option value="due_date" {{ request('sort_by') === 'due_date' ? 'selected' : '' }}>Due Date</option>
                </select>

                <select name="sort_order" onchange="this.form.submit()"
                    class="px-4 py-2 bg-gray-800 border border-gray-700 text-white rounded-md focus:ring-2 focus:ring-blue-600">
                    <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </form>

            <form method="POST" action="{{ route('tasks.deleteAll') }}" onsubmit="return confirm('Are you sure you want to delete all tasks?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 transition-colors">
                    Delete All Tasks
                </button>
            </form>
        </div>

        <div class="bg-gray-900 shadow-lg rounded-lg p-6 mb-6 border border-gray-700">
            <h2 class="text-xl font-semibold text-white mb-4">Task Completion</h2>
            @php
                $totalTasks = $tasks->count();
                $completedTasks = $tasks->where('status', 1)->count();
                $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

                // Determine emoji based on completion percentage
                $emoji = '';
                if ($completionRate === 0) {
                    $emoji = '😞'; // Sad face
                } elseif ($completionRate < 25) {
                    $emoji = '😐'; // Neutral face
                } elseif ($completionRate < 50) {
                    $emoji = '🙂'; // Slightly smiling face
                } elseif ($completionRate < 75) {
                    $emoji = '😊'; // Smiling face
                } elseif ($completionRate < 100) {
                    $emoji = '😄'; // Grinning face
                } else {
                    $emoji = '🎉'; // Party popper
                }
            @endphp

            <div class="relative w-full h-4 bg-gray-700 rounded-full">
                <div class="absolute top-0 left-0 h-full rounded-full transition-all"
                    style="width: {{ $completionRate }}%; background-color: {{ $completionRate === 100 ? '#4caf50' : '#9400FF' }};">
                </div>
            </div>
            <div class="flex justify-between items-center mt-2 text-gray-300">
                <span class="text-sm">Completed: {{ $completionRate }}%</span>
                <span class="text-2xl">{{ $emoji }}</span>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="space-y-4">
            @foreach ($tasks as $task)
                <div class="flex items-center justify-between p-4 border border-purple-600 rounded-md"
                    style="background-color: {{ $task->status ? '#4caf50' : $task->color }};">
                    @php
                        $textColor = \App\Helpers\ColorHelper::isLightColor($task->color) ? 'text-black' : 'text-white';
                    @endphp

                    <div class="flex space-x-4 items-center">
                        <!-- Toggle Status -->
                        <form method="POST" action="{{ route('tasks.toggleStatus', $task) }}">
                            @csrf
                            @method('PATCH')
                            <input type="checkbox" onchange="this.form.submit()"
                                {{ $task->status ? 'checked' : '' }} class="h-6 w-6 text-blue-500">
                        </form>

                        <div class="p-2 rounded-md">
                            <h3 class="font-bold text-xl {{ $textColor }} {{ $task->status ? 'line-through opacity-60' : '' }}">
                                {{ $loop->iteration }}. {{ $task->name }}
                            </h3>
                            <p class="text-sm {{ $textColor }} opacity-75">{{ $task->due_date }}</p>
                        </div>
                    </div>

                    <!-- Delete Task -->
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <div class="flex justify-center items-center">
                <div class="flex space-x-2">
                    <!-- Previous Button -->
                    @if ($tasks->onFirstPage())
                        <button class="px-4 py-2 bg-gray-500 text-white rounded-md cursor-not-allowed" disabled>
                            &laquo; Previous
                        </button>
                    @else
                        <a href="{{ $tasks->previousPageUrl() }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            &laquo; Previous
                        </a>
                    @endif

                    <!-- Pagination Numbers -->
                    @foreach ($tasks->getUrlRange(1, $tasks->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="px-4 py-2 rounded-md {{ $page == $tasks->currentPage() ? 'bg-purple-700 text-white' : 'bg-gray-700 text-gray-300 hover:bg-purple-500 hover:text-white' }} transition-all">
                            {{ $page }}
                        </a>
                    @endforeach

                    <!-- Next Button -->
                    @if ($tasks->hasMorePages())
                        <a href="{{ $tasks->nextPageUrl() }}"
                            class="px-4 py-2 bg-purple-700 text-white rounded-md hover:bg-purple-500 transition-colors">
                            Next &raquo;
                        </a>
                    @else
                        <button class="px-4 py-2 bg-gray-700 text-white rounded-md cursor-not-allowed" disabled>
                            Next &raquo;
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
