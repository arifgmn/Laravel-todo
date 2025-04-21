<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Todo List</title>
    {{-- Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body>
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

        <!-- Form Todo List Here -->
        @include('components._add-todo')

        <hr class="my-4 border-t border-gray-300">

        {{-- Filter completed and high to low sort --}}
        @include('components._filter')

        {{-- Todo List --}}
        @foreach ($todos as $todo)
            @include('components._todo-card', ['todo' => $todo])
        @endforeach
        <div class="mt-4 mb-8">
            {{ $todos->links() }}
        </div>

        {{-- Clear-completed button --}}
        @include('components._clear-completed')
    </div>
</body>
<script>
    setTimeout(() => {
        const msg = document.getElementById('flash-msg');
        if (msg) msg.style.display = 'none';
    }, 3000);
</script>

</html>
