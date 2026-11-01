<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class TestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Routes are already behind the 'auth' middleware, so any logged-in user may manage testimonials
        return true;
    }

    /**
     * Normalize input before the rules run.
     */
    protected function prepareForValidation(): void
    {
        // Only capitalize the first letter - job titles like "CTO at Odevo" must keep their casing
        if ($this->filled('title')) {
            $this->merge(['title' => Str::ucfirst($this->input('title'))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'testimonial' => 'required|string',
            'image_id' => 'nullable|exists:images,id',
        ];
    }
}
