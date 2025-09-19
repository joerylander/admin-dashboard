<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelper;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index() {
        $testimonials = Testimonial::all();
        return view('projects.portfolio.testimonials.index', ['testimonials' => $testimonials]);
    }

     public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|min:20|max:1000'
        ]);
        $validated['title'] = StringHelper::formatTitle($validated['title']);
        Testimonial::create($validated);
      return redirect()->route('portfolio.benefits.index')->with('success', 'Testimonial created');
    }

    public function update(Request $request, Testimonial $Testimonial) {
         $validated = $request->validate([
        'title' => 'required|string|max:100',
        'description' => 'required|string|min:20|max:1000'
    ]);
      $validated['title'] = StringHelper::formatTitle($validated['title']);
        $Testimonial->update($validated);
      return redirect()->route('portfolio.benefits.index')->with('success', 'Testimonial ' . $Testimonial->title . ' updated');
    }

    public function destroy(Testimonial $Testimonial) {
        $Testimonial->delete();
       return redirect()->route('portfolio.benefits.index')->with('success', 'Testimonial deleted: ' . $Testimonial->title);
    }
}
