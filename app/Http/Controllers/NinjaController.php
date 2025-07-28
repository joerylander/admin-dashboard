<?php

namespace App\Http\Controllers;

use App\Models\Dojo;
use App\Models\Ninja;
use Illuminate\Http\Request;

class NinjaController extends Controller
{
    public function index() {
        // with() method tells laravel to eager load all related data to the model (all associated dojos to all the ninjas)
        // As opposed to lazy loading. Good for performance reasons, especially on large amounts of data sets
        $ninjas = Ninja::with('dojo')->orderBy('created_at', 'desc')->paginate(10);

        return view('ninjas.index', ["ninjas" => $ninjas]);
    }
    
    public function show(Ninja $ninja) {
        // Eager load related dojo data to the Ninja when using route model binding
        $ninja->load('dojo');
        return view("ninjas.show", ["ninja" => $ninja]);
    }

    public function create() {
        $dojos = Dojo::all();

        return view("ninjas.create", ['dojos' => $dojos]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'skill' => 'required|integer|min:0|max:100',
            'bio' => 'required|string|min:20|max:1000',
            'dojo_id' => 'required|exists:dojos,id'
        ]);
                
        Ninja::create($validated);

        return redirect()->route('ninjas.index')->with('success', 'Ninja Created: ' . $request->input('name'));
    }

    public function destroy(Ninja $ninja) {
        $ninja->delete();
        return redirect()->route('ninjas.index')->with('success', 'Ninja Deleted: ' . $ninja->name);
    }
}
