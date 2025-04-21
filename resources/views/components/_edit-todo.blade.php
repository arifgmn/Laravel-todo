<!-- Todo List Here -->
<form action="{{ route('todos.update', $todo->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            {{-- Task --}}
            <label for="task" class="mr-1 block text-sm font-medium">Task:</label>
            <input type="text" name="task"
                class="w-md p-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 {{ $errors->has('task') ? 'border-red-500' : 'border-gray-300' }}"
                placeholder="Add a new task..." value="{{ old('task', $todo->task) }}" required>
        </div>

        <div class="flex items-center">
            {{-- Priority --}}
            <label for="priority" class="mr-1 block text-sm font-medium">Priority:</label>
            <select name="priority" id="priority"
                class="p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="low" {{ old('priority', $todo->priority) == 'low' ? 'selected' : '' }}>Low
                </option>
                <option value="medium" {{ old('priority', $todo->priority) == 'medium' ? 'selected' : '' }}>
                    Medium</option>
                <option value="high" {{ old('priority', $todo->priority) == 'high' ? 'selected' : '' }}>
                    High
                </option>
            </select>
        </div>

        <div class="flex items-center">
            {{-- Due Date --}}
            <label for="due_date" class="mr-1 block text-sm font-medium">Due Date:</label>
            <input type="date" name="due_date"
                class="p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                value="{{ old('due_date', $todo->due_date ?? '') }}">
        </div>
    </div>

    {{-- Description --}}
    <div class="flex flex-col my-2">
        <label for="description" class="mb-1 block text-sm font-medium">Description:</label>
        <textarea name="description" id="description" rows="3"
            class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $todo->description ?? '') }}</textarea>
    </div>

    <div class="flex justify-end p-3">
        {{-- Button --}}
        <button type="submit"
            class="float-right px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-150 ease-in-out transform hover:scale-105 cursor-pointer">Edit
            Task</button>
    </div>
</form>
