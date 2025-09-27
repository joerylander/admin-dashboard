<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    /** @use HasFactory<\Database\Factories\BenefitsFactory> */
    use HasFactory;
    
    protected $fillable = ['title', 'description'];
}
