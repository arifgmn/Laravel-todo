<div class="mt-2 py-4 px-2 flex justify-between items-center">
    <div class="flex items-center gap-2">
        {{-- Sort by Completed --}}
        <a href="{{ route('todos.index') }}"
            class="hover:text-blue-500 hover:underline active:text-blue-500 focus:text-blue-500">All</a>
        <a href="{{ route('todos.index', ['sort' => 'active']) }}"
            class="hover:text-blue-500 hover:underline active:text-blue-500 focus:text-blue-500">Active</a>
        <a href="{{ route('todos.index', ['sort' => 'completed']) }}"
            class="hover:text-blue-500 hover:underline active:text-blue-500 focus:text-blue-500">Completed</a>

        {{-- Sort by Priority --}}
        <form action="{{ route('todos.index') }}" class="flex items-center">
            <label for="sort" class="mr-2 text-sm font-semibold">Sort by Priority:</label>
            <select name="sort" id="sort" onchange="this.form.submit()"
                class="p-2 border rounded-lg shadow-sm border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Default --</option>
                <option value="high" {{ request('sort') === 'high' ? 'selected' : '' }}>High to Low</option>
                <option value="low" {{ request('sort') === 'low' ? 'selected' : '' }}>Low to High</option>
            </select>
        </form>
    </div>

    <div>
        {{-- Search --}}
        <form action="{{ route('todos.index') }}" method="GET" class="w-md flex justify-end items-center gap-1">
            <input type="text" name="search" placeholder="Search tasks..." value="{{ request('search') }}"
                class="p-2 border border-gray-300 shadow-sm rounded w-xs focus:ring-2 focus:outline-none focus:ring-blue-600">
            <button type="submit"
                class="px-4 py-2 rounded-lg transition-all duration-150 ease-in-out transform hover:scale-110 cursor-pointer">🔍</button>
        </form>
    </div>

</div>

<div class="flex justify-between items-center gap-2 mb-4 px-4">
    {{-- Toggle all completed --}}
    <form action="{{ route('todos.toggle-all') }}" method="POST" id="toggleAllForm" class="flex items-center gap-2">
        @csrf
        <input type="checkbox" id="toggleAll" name="toggleAll" onchange="this.form.submit()"
            class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-green-500 transition-all duration-150 hover:scale-110 cursor-pointer"
            {{ $allCompleted ? 'checked' : '' }}>
        <label for="toggleAll" class="text-sm font-semibold cursor-pointer">Toggle all completed</label>
    </form>
</div>
