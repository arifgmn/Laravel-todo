<div x-data="{ showSubtasks: false }" @click="showSubtasks = !showSubtasks"
    class="cursor-pointer flex-col justify-between items-center bg-gray-200 hover:bg-gray-300 p-2 rounded-lg mb-2 transition-all duration-300 ease-in-out">

    {{-- Todo Card List --}}
    <div
        class="flex z-0 justify-between ietms-center bg-gray-200 hover:bg-gray-300 p-2 rounded-lg mb-2 transition-all duration-300 ease-in-out opacity-0 animate-fade-in-scale">
        {{-- Checkbox --}}
        <form action="{{ route('todos.toggle', $todo->id) }}" method="POST" class="flex items-center gap-2">
            @csrf
            @method('PATCH')
            <input type="checkbox" onchange="this.form.submit()" {{ $todo->completed ? 'checked' : '' }}
                class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-green-500 cursor-pointer transition-all duration-150 hover:scale-110">
            {{-- Tasks --}}
            <div class="flex items-center">
                <span
                    class="text-lg transition-all duration-300 {{ $todo->completed ? 'line-through text-gray-400' : '' }}">
                    {{ $todo->task }}
                </span>
                {{-- Description --}}
                @if ($todo->description)
                    <span class="ml-8 text-sm text-gray-600 italic">
                        <p>{{ $todo->description }}</p>
                    </span>
                @endif
            </div>
        </form>


        <div class="flex items-center">
            {{-- Priority --}}
            <span
                class="mr-2 px-2 py-1 text-xs rounded-full font-semibold
                            {{ $todo->priority === 'high' ? 'bg-red-500 text-white' : '' }}
                             {{ $todo->priority === 'medium' ? 'bg-yellow-400 text-black' : '' }}
                              {{ $todo->priority === 'low' ? 'bg-green-400 text-black' : '' }}
                            ">
                {{ ucfirst($todo->priority) }}
            </span>
            {{-- Due Date --}}
            @if ($todo->due_date)
                <small
                    style="color: {{ \Carbon\Carbon::parse($todo->due_date)->isPast() && !$todo->completed ? 'red' : 'inherit' }};"
                    class="px-2">
                    (Due: {{ \Carbon\Carbon::parse($todo->due_date)->format('M d, Y') }})
                </small>
            @endif

            {{-- Edit and Delete Buttons --}}
            <div @click.stop x-data="{ showConfirm: false }" class="flex items-center gap-2">
                <a href="{{ route('todos.edit', $todo->id) }}"
                    class="px-2 py-0.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-150 ease-in-out transform hover:scale-105 cursor-pointer">
                    📝
                </a>
                {{-- Trigger Button --}}
                <button @click="showConfirm = true"
                    class="px-2 py-0.5 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-150 ease-in-out transform hover:scale-105 cursor-pointer">
                    🗑️
                </button>

                {{-- Confirmation Modal --}}
                <div x-show="showConfirm" x-transition class="fixed inset-0 z-50 flex items-center justify-center">
                    <div @click.outside="showConfirm = false" class="bg-white p-6 rounded-lg shadow-xl w-80">
                        <h2 class="text-lg font-semibold mb-4">Are you sure?</h2>
                        <p class="mb-4 text-sm text-gray-600">This action cannot be undone.</p>

                        <div class="flex justify-end gap-2">
                            {{-- cancel --}}
                            <button @click="showConfirm = false"
                                class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                            {{-- confirm delete --}}
                            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Subtasks List --}}
    @if ($todo->subtasks->count())
        <ul x-show="showSubtasks" x-transition @click.stop class="ml-4 mt-2 space-y-1">
            @foreach ($todo->subtasks as $subtask)
                <li class="flex items-center gap-2">
                    <form action="{{ route('subtasks.toggle', $subtask->id) }}" method="POST"
                        class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <input type="checkbox" name="completed" class="" onchange="this.form.submit()"
                            {{ $subtask->completed ? 'checked' : '' }}>
                    </form>
                    <span
                        class="{{ $subtask->completed ? 'line-through text-gray-400' : '' }}">{{ $subtask->title }}</span>
                    <form action="{{ route('subtasks.destroy', $subtask->id) }}" method="POST"
                        onsubmit="return confirm('Delete this subtask?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-2 rounded text-red-500 hover:bg-red-600 hover:text-white transition-all duration-150 ease-in-out transform hover:scale-105 cursor-pointer">X</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Subtasks form --}}
    <form x-show="showSubtasks" x-transition @click.stop action="{{ route('subtasks.store', $todo->id) }}"
        method="POST" class="ml-4 my-2 flex items-center gap-2 w-2xs">
        @csrf
        <input type="text" name="title" placeholder="Add subtask..."
            class="flex-1 py-0.5 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit"
            class="px-1 py-0.5 bg-green-500 text-white rounded hover:bg-green-600 transition-all duration-150 ease-in-out hover:scale-105 cursor-pointer"><svg
                xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg></button>
    </form>
</div>
