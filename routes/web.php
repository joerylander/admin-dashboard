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
Route::prefix('auth')->controller(AuthController::class)->name('')->group(function() {
    Route::middleware('guest')->group(function() {
        Route::get('/login', 'showLogin')->name('show.login');
        Route::post('/login', 'login')->name('login');
    });
    Route::post('/logout', 'logout')->name('logout');
});

// Protected routes
Route::middleware('auth')->group(function() {
    // Media
    Route::prefix('media')->controller(ImageController::class)->name('media.')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{image}', 'destroy')->name('destroy');
    });

    // Projects 
    Route::prefix('/projects')->group(function() {
        Route::get('/', [ProjectsController::class, 'index'])->name('projects.index');
        // Portfolio
        Route::prefix('/portfolio')->name('portfolio.')->group(function() {
            Route::get('/', [PortfolioController::class, 'index'])->name('index');
            // Benefits
            Route::prefix('benefits')->controller(BenefitController::class)->name('benefits.')->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::put('/{benefit}', 'update')->name('update');
                Route::delete('/{benefit}', 'destroy')->name('destroy');
            });
            // Testimonials
            Route::prefix('testimonials')->controller(TestimonialController::class)->name('testimonials.')->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::put('/{testimonial}', 'update')->name('update');
                Route::delete('/{testimonial}', 'destroy')->name('destroy');
            });
        });
    });
});