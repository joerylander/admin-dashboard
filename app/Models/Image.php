<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
     protected $fillable = ['file_path', 'original_filename', 'mime_type', 'size'];
     protected $appends = ['url'];
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    public function getUrlAttribute() 
    {
        return Storage::url($this->file_path);
    }
}
