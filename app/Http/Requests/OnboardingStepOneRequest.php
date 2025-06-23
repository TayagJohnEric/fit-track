<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnboardingStepOneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'sex' => ['required', 'in:Male,Female,Other'],
            'height_cm' => ['required', 'numeric', 'min:100', 'max:250'],
            'current_weight_kg' => ['required', 'numeric', 'min:30', 'max:300'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'height_cm.min' => 'Height must be at least 100 cm.',
            'height_cm.max' => 'Height cannot exceed 250 cm.',
            'current_weight_kg.min' => 'Weight must be at least 30 kg.',
            'current_weight_kg.max' => 'Weight cannot exceed 300 kg.',
        ];
    }
}
