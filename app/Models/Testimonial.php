<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /** @use HasFactory<\Database\Factories\TestimonialFactory> */
    use HasFactory;
    protected $fillable = ['firstName', 'lastName', 'title', 'testimonial', 'image_id'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
