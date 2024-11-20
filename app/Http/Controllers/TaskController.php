<?php
// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Laravel\Prompts\Table;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller {
    public function index() {
        $tasks = DB::Table('Tasks AS t')
            ->select(
                't.id', 't.title', 't.category_id', 't.is_completed',
                'c.name AS category_name', 'p.name AS priority_name', 't.priority_id')
            ->leftJoin('categories AS c','c.id','=','t.category_id')
            ->leftJoin('priorities AS p','p.id','=','t.priority_id')
            ->orderBy('t.priority_id','asc')
            ->groupBy('t.category_id', 't.id', 't.title', 't.is_completed', 'c.name', 'p.name', 't.priority_id')
            ->get();

        $categories = $this->category();
        $priorities = $this->priorities();
        return view('tasks.todolist', compact(
            'tasks',
            'categories',
            'priorities'
        ));
    }

    // Get the list of categories
    public function category() {
        $categories = DB::Table('categories')->orderBy('id', 'asc')->get();
        return $categories;
    }

    // Save new task created
    public function store(Request $request) {
        //print_r($request->all());
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'priority' => 'required'
        ]);
        Task::create([
            'title' => $request->title,
            'category_id' => $request->category,
            'priority_id' => $request->priority
        ]);
        return redirect()->route('tasks.index');
    }

    // Update task completed
    public function update(Request $request, Task $task) {
        $task->update(['is_completed' => $request->has('is_completed')]);
        return redirect()->route('tasks.index');
    }

    // Delete a task
    public function destroy(Task $task) {
        $task->delete();
        return redirect()->route('tasks.index');
    }

    // Get the list of priority names
    public function priorities() {
        $priorities = DB::table('priorities')
            ->orderBy('id','asc')
            ->get();
        return $priorities;
    }
}
