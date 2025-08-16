<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Benefit;
use App\Http\Controllers\Controller;

class BenefitController extends Controller
{
    public function index() {
        $benefits = Benefit::all();
        return response()->json([
            'message' => 'Benefits data retrieved successfully',
            'data' => $benefits
        ]);
    }
}
