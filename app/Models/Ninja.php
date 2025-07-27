<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ninja extends Model
{
    // define which attributes are mass assignable, i.e. guarded properties. No other attributes can be mass assigned in this model
    protected $fillable = ['name', 'skill', 'bio'];

    /** @use HasFactory<\Database\Factories\NinjaFactory> */
    use HasFactory;
}
