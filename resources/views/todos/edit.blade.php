<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Edit Todo</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body>
    {{-- @dd($todo->priority) --}}
    <div class="w-full max-w-4xl p-4 bg-white rounded-lg shadow-md">
        {{-- Message --}}
        @if (session('success'))
            <div id="flash-msg"
                class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 shadow-sm transition-all duration-300 ease-in-out opacity-0 animate-fade-in-scale">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div id="flash-msg"
                class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 shadow-sm transition-all duration-300 ease-in-out opacity-0 animate-fade-in-scale">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-center mb-8">Todo List</h1>
        {{-- Edit Form --}}
        @include('components._edit-todo')

        <hr class="my-4 border-t border-gray-300">

        {{-- Filter completed and high to low sort --}}
        @include('components._filter')

        {{-- Todo List --}}
        @foreach ($todos as $todo)
            @include('components._todo-card', ['todo' => $todo])
        @endforeach
        <div class="mt-4">
            {{ $todos->links() }}
        </div>

        {{-- Clear-completed button --}}
        <div class="flex justify-between items-center px-3 mt-8">
            <a href="{{ route('todos.index') }}"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-150 ease-in-out transform hover:scale-105 cursor-pointer">Back</a>

            @include('components._clear-completed')
        </div>
    </div>
</body>

</html>
