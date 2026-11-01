<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ImageController extends Controller
{
   public function index() {
      $images = Image::orderBy('created_at', 'desc')->get();
      return view('media.index', ['images' => $images, 'categories' => Image::CATEGORIES]);
   }

   public function store(Request $request) {
      $validated = $request->validate([
         'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
         'category' => ['required', Rule::in(Image::CATEGORIES)]
      ]);

      $file = $request->file('image');
      // store() generates a unique, safe filename and returns the relative path
      $filePath = $file->store("images/{$validated['category']}", 'public');

      Image::create([
         'file_path' => $filePath,
         'original_filename' => $file->getClientOriginalName(),
         'mime_type' => $file->getMimeType(),
         'size' => $file->getSize()
      ]);

      return redirect()->route('media.index')->with('success', 'Image uploaded successfully');
   }

   public function destroy(Image $image) {
      Storage::disk('public')->delete($image->file_path);

      $image->delete();

      return redirect()->route('media.index')->with('success', 'Image deleted');
   }
}
