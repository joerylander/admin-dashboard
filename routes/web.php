<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BenefitController;
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

// Auth
Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.index');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
// Benefits
Route::get('dashboard/benefits', [BenefitController::class, 'index'])->name('benefits.index');
Route::post('dashboard/benefits', [BenefitController::class, 'store'])->name('benefits.store');
Route::put('dashboard/benefits/{benefit}', [BenefitController::class, 'update'])->name('benefits.update');
Route::delete('dashboard/benefits/{benefit}', [BenefitController::class, 'destroy'])->name('benefits.destroy');