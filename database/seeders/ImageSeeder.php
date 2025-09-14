<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedRealImages();
    }

    private function seedRealImages(): void 
    {
        $imageFiles = Storage::disk('public')->allFiles('images');

        foreach ($imageFiles as $filePath) {
            if (!$this->isImageFile($filePath)) continue;

            $fullPath = Storage::disk('public')->path($filePath);

            Image::create([
                'file_path' => $filePath,
                'original_filename' => basename($filePath),
                'mime_type' => mime_content_type($fullPath),
                'size' => Storage::disk('public')->size($filePath)
            ]);
        }
    }

    private function isImageFile(string $filePath): bool
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }
}
