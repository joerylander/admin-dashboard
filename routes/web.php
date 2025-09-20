<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\TestimonialController;



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
Route::prefix('/projects')->group(function() {
    Route::get('/', [ProjectsController::class, 'index'])->name('projects.index');
    // Portfolio
    Route::prefix('/portfolio')->name('portfolio.')->group(function() {
        Route::get('/', [PortfolioController::class, 'index'])->name('index');
        // Benefits
        Route::prefix('benefits')->name('benefits.')->group(function() {
            Route::get('/', [BenefitController::class, 'index'])->name('index');
            Route::post('/', [BenefitController::class, 'store'])->name('store');
            Route::put('/{benefit}', [BenefitController::class, 'update'])->name('update');
            Route::delete('/{benefit}', [BenefitController::class, 'destroy'])->name('destroy');
        });
        // Testimonials
        Route::prefix('testimonials')->name('testimonials.')->group(function() {
            Route::get('/', [TestimonialController::class, 'index'])->name('index');
            Route::post('/', [TestimonialController::class, 'store'])->name('store');
            Route::put('/{testimonial}', [TestimonialController::class, 'update'])->name('update');
            Route::delete('/{testimonial}', [TestimonialController::class, 'destroy'])->name('destroy');
        });
    });
});