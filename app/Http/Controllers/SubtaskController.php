<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Subtask;


class SubtaskController extends Controller
{
    public function store(Request $requets, Todo $todo)
    {
        $requets->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo->subtasks()->create([
            'title' => $requets->title,
            'completed' => false,
        ]);

        return back()->with('success', 'Subtask added!');
    }

    public function toggle(Subtask $subtask)
    {
        $subtask->update([
            'completed' => !$subtask->completed,
        ]);

        return back();
    }

    public function destroy($id)
    {
        Subtask::destroy($id);
        return redirect()->route('todos.index')->with('success', 'Subtask successfully deleted!');
    }
}