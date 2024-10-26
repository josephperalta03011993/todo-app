<?php
// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function index() {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request) {
        $request->validate(['title' => 'required']);
        Task::create(['title' => $request->title]);
        return redirect()->route('tasks.index');
    }

    public function update(Request $request, Task $task) {
        $task->update(['is_completed' => $request->has('is_completed')]);
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task) {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
