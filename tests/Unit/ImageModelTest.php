<?php

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;

test('example', function () {
    expect(true)->toBeTrue();
});

test('it can create an image', function() {
    // Arrange - Set up mock data
    $imageData = [
        'file_path' => 'images/test.jpg',
        'original_filename' => 'test.jpg',
        'mime_type' => 'image/jpeg',
        'size' => 1024
    ];

    // Act - Create the image
    $image = new Image($imageData);
    // dump($image);
    // Assert - Check it worked
    expect($image)->toBeInstanceOf(Image::class);
    expect($image->file_path)->toBe('images/test.jpg');
    expect($image->original_filename)->toBe('test.jpg');
});
