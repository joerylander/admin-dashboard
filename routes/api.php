<?php

use App\Http\Controllers\BenefitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Benefits
Route::get('/benefits', [BenefitController::class, 'index']);