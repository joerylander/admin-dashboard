<?php

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Swap the real public disk for a temporary one so tests never touch storage/app/public
    Storage::fake('public');
    $this->actingAs(User::factory()->create());
});

test('an image can be uploaded into a category folder', function () {
    $this->post(route('media.store'), [
        'image' => UploadedFile::fake()->image('Profile photo.jpg'),
        'category' => 'profiles',
    ])->assertRedirect(route('media.index'));

    $image = Image::sole();
    expect($image->original_filename)->toBe('Profile photo.jpg');
    expect($image->file_path)->toStartWith('images/profiles/');
    Storage::disk('public')->assertExists($image->file_path);
});

test('an upload with an unknown category is rejected', function (string $category) {
    $this->post(route('media.store'), [
        'image' => UploadedFile::fake()->image('photo.jpg'),
        'category' => $category,
    ])->assertSessionHasErrors('category');

    expect(Image::count())->toBe(0);
})->with(['../../evil', 'secret']);

test('deleting an image removes the file as well as the record', function () {
    $path = UploadedFile::fake()->image('photo.jpg')->store('images/general', 'public');
    $image = Image::factory()->create(['file_path' => $path]);

    $this->delete(route('media.destroy', $image))->assertRedirect(route('media.index'));

    Storage::disk('public')->assertMissing($path);
    $this->assertModelMissing($image);
});
