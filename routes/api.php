<?php

use App\Http\Controllers\Api\BenefitController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// NOTE: all api routes have implicit route /api/
// E.g. /api/user -> access user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Benefits
Route::get('/benefits', [BenefitController::class, 'index']);

// Testimonials
Route::get('testimonials', [TestimonialController::class, 'index']);