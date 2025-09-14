<?php

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('example', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

test('it can create and save an image', function() {
        // Arrange - Set up test data
    $imageData = [
        'file_path' => 'images/test.jpg',
        'original_filename' => 'test.jpg',
        'mime_type' => 'image/jpeg',
        'size' => 1024
    ];

    // Act - Create and save to database
    $image = Image::create($imageData);
dump($image);
    // Assert - Check it worked
    expect($image)->toBeInstanceOf(Image::class);
    expect($image->id)->not()->toBeNull(); // ← This proves it was saved!
    expect($image->file_path)->toBe('images/test.jpg');
    
    // Assert it exists in database
    $this->assertDatabaseHas('images', [
        'file_path' => 'images/test.jpg',
        'original_filename' => 'test.jpg'
    ]);
});