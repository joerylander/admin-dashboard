<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NinjaController;

Route::get('/', function () {
    return view('dashboard');
});
Route::get('/ninjas', [NinjaController::class, 'index'])->name('ninjas.index');
Route::get("/ninjas/create", [NinjaController::class, 'create'])->name('ninjas.create');
// Note: Wildcards routes need to be last as Laravel grabs the first match, going up to down
Route::get("/ninjas/{ninja}", [NinjaController::class, 'show'])->name('ninjas.show');
Route::post("/ninjas", [NinjaController::class, 'store'])->name('ninjas.store');
Route::delete("/ninjas/{ninja}", [NinjaController::class, 'destroy'])->name('ninjas.destroy');

Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');