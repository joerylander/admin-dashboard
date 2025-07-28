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
    
    public function show($id) {
        $ninja = Ninja::with('dojo')->findOrFail($id);
        return view("ninjas.show", ["ninja" => $ninja]);
    }

    public function create() {
        $dojos = Dojo::all();

        return view("ninjas.create", ['dojos' => $dojos]);
    }

    public function store() {}
}
