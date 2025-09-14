<?php

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

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

test('it can create and save an image using factory', function() {
    // Act - Use factory to create image
    $image = Image::factory()->create();
    
    // Assert
    expect($image)->toBeInstanceOf(Image::class);
    expect($image->id)->not()->toBeNull();
    expect($image->file_path)->toContain('images/');
    
    dump("Created image: " . $image->file_path);
    dump("URL would be: " . $image->url);
});