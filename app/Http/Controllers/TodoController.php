<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Redis;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::query();

        $sort = $request->query('sort');
        $search = $request->query('search');

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('task', 'like', "%$search%")->orWhere('description', 'like', "%$search");
            });
        }

        // Filtering by completed status
        if ($sort === 'completed') {
            $query->where('completed', true);
        } elseif ($sort === 'active') {
            $query->where('completed', false);
        }

        // High to low sort
        if ($sort === 'high') {
            $query->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 WHEN 'low' THEN 3 ELSE 4 END");
        } elseif ($sort === 'low') {
            $query->orderByRaw("CASE priority WHEN 'low' THEN 1 WHEN 'medium' THEN 2 WHEN 'high' THEN 3 ELSE 4 END");
        } else {
            $query->latest(); // default sort by created_at
        }

        $todos = $query->with('subtasks')->latest()->simplePaginate(5);

        $allCompleted = Todo::where('completed', false)->count() === 0;

        return view('todos.index', compact('todos', 'allCompleted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
        ]);

        Todo::create([
            'task' => $request->task,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'description' => $request->description,
        ]);
        return redirect()->route('todos.index')->with('success', 'Task added successfully!');
    }

    public function destroy($id)
    {
        Todo::destroy($id);
        return redirect()->route('todos.index')->with('success', 'Task successfully deleted!');
    }

    public function toggle($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->completed = !$todo->completed;
        $todo->save();

        return redirect()->route('todos.index');
    }

    public function toggleAll()
    {
        $allCompleted = Todo::where('completed', false)->count() === 0;

        Todo::query()->update(['completed' => !$allCompleted]);

        return redirect()->route('todos.index')->with('success', 'All tasks updated!');
    }

    public function edit(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todos = Todo::with('subtasks')->latest()->paginate(5);

        $allCompleted = Todo::where('completed', false)->count() === 0;

        return view('todos.edit', compact('todo', 'todos', 'allCompleted'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update([
            'task' => $request->task,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'description' => $request->description,
        ]);

        return redirect()->route('todos.index')->with('success', 'Task update successfully!');
    }

    public function clearCompleted()
    {
        // Delete all completed
        Todo::where('completed', true)->delete();

        // Redirect back to the index page
        return redirect()->route('todos.index')->with('success', 'Completed tasks cleared!');
    }
}