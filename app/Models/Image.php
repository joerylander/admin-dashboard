<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    // Allowed upload folders under storage/app/public/images
    public const CATEGORIES = ['general', 'profiles', 'projects'];

    protected $fillable = ['file_path', 'original_filename', 'mime_type', 'size'];

    protected $appends = ['url'];

    protected function url(): Attribute
    {
        return Attribute::get(fn () => Storage::disk('public')->url($this->file_path));
    }
}
