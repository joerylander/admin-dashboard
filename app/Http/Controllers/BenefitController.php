<?php

namespace App\Http\Controllers;

use App\Helpers\StringHelper;
use App\Models\Benefit;
use Illuminate\Http\Request;

// If you need form data → You need Request $request
// If you don't need form data → You don't need Request $request - Can use route model binding instead

class BenefitController extends Controller
{
    public function index() {
        $benefits = Benefit::all();
       return view('projects.portfolio.benefits.index', ['benefits' => $benefits]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|min:20|max:1000'
        ]);
        $validated['title'] = StringHelper::formatTitle($validated['title']);
        Benefit::create($validated);
      return redirect()->route('portfolio.benefits.index')->with('success', 'Benefit created');
    }

    public function update(Request $request, Benefit $benefit) {
         $validated = $request->validate([
        'title' => 'required|string|max:100',
        'description' => 'required|string|min:20|max:1000'
    ]);
      $validated['title'] = StringHelper::formatTitle($validated['title']);
        $benefit->update($validated);
      return redirect()->route('portfolio.benefits.index')->with('success', 'Benefit ' . $benefit->title . ' updated');
    }

    public function destroy(Benefit $benefit) {
        $benefit->delete();
       return redirect()->route('portfolio.benefits.index')->with('success', 'Benefit deleted: ' . $benefit->title);
    }
}
