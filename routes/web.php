<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NinjaController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/ninjas', [NinjaController::class, 'index']);

Route::get("/ninjas/create", function() {
    return view("ninjas.create");
});

// Note: Wildcards routes need to be last as Laravel grabs the first match, going up to down
Route::get("/ninjas/{id}", function ($id) {
    return view("ninjas.show", ["id" => $id]);
});
