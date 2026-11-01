<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialRequest;
use App\Models\Image;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index() {
        $testimonials = Testimonial::with('image')->get();
        $images = Image::orderBy('original_filename')->get();
        return view('projects.portfolio.testimonials.index', compact('testimonials', 'images'));
    }

    public function store(TestimonialRequest $request) {
        Testimonial::create($request->validated());
        return redirect()->route('portfolio.testimonials.index')->with('success', 'Testimonial created');
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial) {
        $testimonial->update($request->validated());
        return redirect()->route('portfolio.testimonials.index')->with('success', 'Testimonial ' . $testimonial->title . ' updated');
    }

    public function destroy(Testimonial $testimonial) {
        $testimonial->delete();
        return redirect()->route('portfolio.testimonials.index')->with('success', 'Testimonial deleted: ' . $testimonial->title);
    }
}
