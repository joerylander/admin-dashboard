<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    protected $fillable = ['title', 'description'];
    /** @use HasFactory<\Database\Factories\BenefitsFactory> */
    use HasFactory;
}
