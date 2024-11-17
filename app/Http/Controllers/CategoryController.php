<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Laravel\Prompts\Table;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {

    public function index() {
        $categories = DB::Table('categories')->orderBy('id', 'asc')->get();
        return view('tasks.index', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'=> 'required'
        ]);
        //dd($request->all());
        Category::create([
            'name' => $request->name,
            'slug'=> $request->slug,
            'description'=> $request->description
        ]);
        return redirect()->route('categories.index');
    }

}
