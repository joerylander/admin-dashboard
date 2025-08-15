<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use Illuminate\Http\Request;

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
