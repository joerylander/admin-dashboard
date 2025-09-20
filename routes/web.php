<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\TestimonialController;

if (!defined('PORTFOLIO_PATH')) {
     define('PORTFOLIO_PATH', '/projects/portfolio');
}

Route::get('/', function () {
    return view('projects.index'); // Edit later to show hero page
});

// Auth
Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.index');

// Media
Route::prefix('media')->name('media.')->group(function() {
    Route::get('/', [ImageController::class, 'index'])->name('index');
    Route::post('/', [ImageController::class, 'store'])->name('store');
    Route::delete('/{image}', [ImageController::class, 'destroy'])->name('destroy');
});

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
Route::post(PORTFOLIO_PATH . '/testimonials', [TestimonialController::class, 'store'])->name('portfolio.testimonials.store');
Route::put(PORTFOLIO_PATH . '/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('portfolio.testimonials.update');
Route::delete(PORTFOLIO_PATH . '/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('portfolio.testimonials.destroy');
