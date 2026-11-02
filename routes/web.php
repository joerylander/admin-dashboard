<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\BudgetEntryController;
use App\Http\Controllers\BudgetMonthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\RecurringEntryController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('auth')->controller(AuthController::class)->name('')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLogin')->name('show.login');
        Route::post('/login', 'login')->name('login');
    });
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('projects.index'); // Edit later to show hero page
    });
    // Budget
    Route::prefix('budget')->name('budget.')->group(function () {
        Route::controller(BudgetMonthController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{year}/{month}', 'show')->whereNumber('year')->where('month', '0?[1-9]|1[0-2]')->name('show');
            Route::post('/months', 'store')->name('months.store');
        });
        // Entries belong to a month
        Route::controller(BudgetEntryController::class)->name('entries.')->group(function () {
            Route::post('/months/{budgetMonth}/entries', 'store')->name('store');
            Route::put('/entries/{budgetEntry}', 'update')->name('update');
            Route::delete('/entries/{budgetEntry}', 'destroy')->name('destroy');
        });
        // Recurring templates
        Route::prefix('recurring')->controller(RecurringEntryController::class)->name('recurring.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{recurringEntry}', 'update')->name('update');
            Route::delete('/{recurringEntry}', 'destroy')->name('destroy');
        });
    });
    // Media
    Route::prefix('media')->controller(ImageController::class)->name('media.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{image}', 'destroy')->name('destroy');
    });

    // Projects
    Route::prefix('/projects')->group(function () {
        Route::get('/', [ProjectsController::class, 'index'])->name('projects.index');
        // Portfolio
        Route::prefix('/portfolio')->name('portfolio.')->group(function () {
            Route::get('/', [PortfolioController::class, 'index'])->name('index');
            // Benefits
            Route::prefix('benefits')->controller(BenefitController::class)->name('benefits.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::put('/{benefit}', 'update')->name('update');
                Route::delete('/{benefit}', 'destroy')->name('destroy');
            });
            // Testimonials
            Route::prefix('testimonials')->controller(TestimonialController::class)->name('testimonials.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::put('/{testimonial}', 'update')->name('update');
                Route::delete('/{testimonial}', 'destroy')->name('destroy');
            });
        });
    });
});
