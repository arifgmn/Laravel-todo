<form action="{{ route('todos.clearCompleted') }}" method="POST"
    onsubmit="return confirm('Are you sure you want to delete all completed tasks?')">
    @csrf
    <button type="submit"
        class="float-right py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-150 ease-in-out transform hover:scale-105 cursor-pointer">
        Clear All Completed
    </button>
</form>
