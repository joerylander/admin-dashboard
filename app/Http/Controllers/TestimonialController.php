<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelper;
use App\Models\Image;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index() {
        $testimonials = Testimonial::with('image')->get();
        $images = Image::orderBy('original_filename')->get();
        return view('projects.portfolio.testimonials.index', compact('testimonials', 'images'));
    }

     public function store(Request $request) {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'testimonial' => 'required|string',
            'image_id' => 'nullable|exists:images,id'
        ]);
        $validated['title'] = StringHelper::formatTitle($validated['title']);
        Testimonial::create($validated);

      return redirect()->route('portfolio.testimonials.index')->with('success', 'Testimonial created');
    }

    public function update(Request $request, Testimonial $Testimonial) {
         $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'testimonial' => 'required|string',
            'image_id' => 'nullable|exists:images,id'
    ]);
        $validated['title'] = StringHelper::formatTitle($validated['title']);
        $Testimonial->update($validated);
      return redirect()->route('portfolio.testimonials.index')->with('success', 'Testimonial ' . $Testimonial->title . ' updated');
    }

    public function destroy(Testimonial $Testimonial) {
          $Testimonial->delete();
          return redirect()->route('portfolio.testimonials.index')->with('success', 'Testimonial deleted: ' . $Testimonial->title);
    }
}
