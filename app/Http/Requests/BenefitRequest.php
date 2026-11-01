<?php

namespace App\Http\Requests;

use App\Helpers\StringHelper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BenefitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Routes are already behind the 'auth' middleware, so any logged-in user may manage benefits
        return true;
    }

    /**
     * Normalize input before the rules run.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('title')) {
            $this->merge(['title' => StringHelper::formatTitle($this->input('title'))]);
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
            'title' => 'required|string|max:100',
            'description' => 'required|string|min:20|max:1000',
        ];
    }
}
