<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnboardingStepTwoRequest extends FormRequest
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
            'fitness_goal_id' => ['required', 'exists:fitness_goals,id'],
            'experience_level_id' => ['required', 'exists:experience_levels,id'],
            'preferred_workout_type_id' => ['required', 'exists:workout_types,id'],
        ];
    }
}
