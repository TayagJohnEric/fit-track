<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnboardingStepThreeRequest extends FormRequest
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
            'allergies' => ['nullable', 'array'],
            'allergies.*' => ['exists:allergies,id'],
            'daily_budget' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'daily_budget.min' => 'Daily budget cannot be negative.',
            'daily_budget.max' => 'Daily budget is too large.',
        ];
    }
}