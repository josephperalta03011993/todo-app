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
                'c.name AS category_name')
            ->leftJoin('categories AS c','c.id','=','t.category_id')
            ->orderBy('t.category_id','desc')
            ->groupBy('t.category_id', 't.id', 't.title', 't.is_completed', 'c.name')
            ->get();

        $categories = $this->category();
        return view('tasks.todolist', compact('tasks', 'categories'));
    }
    public function category() {
        $categories = DB::Table('categories')->orderBy('id', 'asc')->get();
        return $categories;
    }
    public function store(Request $request) {
        //print_r($request->all());
        $request->validate([
            'title' => 'required',
            'category' => 'required',
        ]);
        Task::create([
            'title' => $request->title,
            'category_id' => $request->category
        ]);
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
