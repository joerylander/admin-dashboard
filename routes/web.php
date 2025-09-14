<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\NinjaController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\TestimonialController;

if (!defined('PORTFOLIO_PATH')) {
     define('PORTFOLIO_PATH', '/projects/portfolio');
}

Route::get('/', function () {
    return view('projects.index'); // Edit later to show hero page
});
Route::get('/ninjas', [NinjaController::class, 'index'])->name('ninjas.index');
Route::get("/ninjas/create", [NinjaController::class, 'create'])->name('ninjas.create');
// Note: Wildcards routes need to be last as Laravel grabs the first match, going up to down
Route::get("/ninjas/{ninja}", [NinjaController::class, 'show'])->name('ninjas.show');
Route::post("/ninjas", [NinjaController::class, 'store'])->name('ninjas.store');
Route::delete("/ninjas/{ninja}", [NinjaController::class, 'destroy'])->name('ninjas.destroy');

// Auth
Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.index');

// Projects 
Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
// Project: Portfolio
Route::get(PORTFOLIO_PATH, [PortfolioController::class, 'index'])->name('portfolio.index');
// Portfolio Benefits
Route::get(PORTFOLIO_PATH . '/benefits', [BenefitController::class, 'index'])->name('portfolio.benefits.index');
Route::post(PORTFOLIO_PATH . '/benefits', [BenefitController::class, 'store'])->name('portfolio.benefits.store');
Route::put(PORTFOLIO_PATH . '/benefits/{benefit}', [BenefitController::class, 'update'])->name('portfolio.benefits.update');
Route::delete(PORTFOLIO_PATH . '/benefits/{benefit}', [BenefitController::class, 'destroy'])->name('portfolio.benefits.destroy');
// Portfolio Testimonials
Route::get(PORTFOLIO_PATH . '/testimonials', [TestimonialController::class, 'index'])->name('portfolio.testimonials.index');