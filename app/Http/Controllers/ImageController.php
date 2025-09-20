<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
   public function index() {
         $images = Image::orderBy('created_at', 'desc')->get();
        return view('media.index', compact('images'));
   }

   public function store(Request $request) {
      $request->validate([
         'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
         'category' => 'required|string'
      ]);

      $file = $request->file('image');
      $filename = time() . '_' . $file->getClientOriginalName();
      $category = $request->category;
      $filePath = "images/$category/$filename";
      // dd($file,$filePath,$category);
      Storage::disk('public')->put($filePath, file_get_contents($file));

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
