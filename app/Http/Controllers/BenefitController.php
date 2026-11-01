<?php

namespace App\Http\Controllers;

use App\Http\Requests\BenefitRequest;
use App\Models\Benefit;

// Form data is validated by BenefitRequest before these methods run → use $request->validated()
// No form data needed → use route model binding instead (e.g. destroy)

class BenefitController extends Controller
{
    public function index() {
        $benefits = Benefit::all();
        return view('projects.portfolio.benefits.index', ['benefits' => $benefits]);
    }

    public function store(BenefitRequest $request) {
        Benefit::create($request->validated());
        return redirect()->route('portfolio.benefits.index')->with('success', 'Benefit created');
    }

    public function update(BenefitRequest $request, Benefit $benefit) {
        $benefit->update($request->validated());
        return redirect()->route('portfolio.benefits.index')->with('success', 'Benefit ' . $benefit->title . ' updated');
    }

    public function destroy(Benefit $benefit) {
        $benefit->delete();
        return redirect()->route('portfolio.benefits.index')->with('success', 'Benefit deleted: ' . $benefit->title);
    }
}
