<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkoutTemplate;
use App\Models\ExperienceLevel;
use App\Models\WorkoutType;

class AdminWorkoutTemplateController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $level = $request->input('experience_level_id');
        $type = $request->input('workout_type_id');

        $templates = WorkoutTemplate::with(['experienceLevel', 'workoutType'])
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($level, fn($q) => $q->where('experience_level_id', $level))
            ->when($type, fn($q) => $q->where('workout_type_id', $type))
            ->latest()
            ->paginate(12);

        $levels = ExperienceLevel::pluck('name', 'id');
        $types = WorkoutType::pluck('name', 'id');

        return view('admin.workout-templates.index', compact('templates', 'search', 'level', 'type', 'levels', 'types'));
    }

   

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'experience_level_id' => 'required|exists:experience_levels,id',
            'workout_type_id' => 'required|exists:workout_types,id',
            'duration_minutes' => 'required|integer|min:1',
            'difficulty_level' => 'required|integer|between:1,5',
        ]);

        WorkoutTemplate::create($validated);

        return redirect()->route('workout_templates.index')
                         ->with('success', 'Workout template created successfully.');
    }

    

    public function update(Request $request, WorkoutTemplate $workout_template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'experience_level_id' => 'required|exists:experience_levels,id',
            'workout_type_id' => 'required|exists:workout_types,id',
            'duration_minutes' => 'required|integer|min:1',
            'difficulty_level' => 'required|integer|between:1,5',
        ]);

        $workout_template->update($validated);

        return redirect()->route('workout_templates.index')
                         ->with('success', 'Workout template updated successfully.');
    }

    public function destroy(WorkoutTemplate $workout_template)
    {
        $workout_template->delete();

        return redirect()->route('workout_templates.index')
                         ->with('success', 'Workout template deleted.');
    }
}
