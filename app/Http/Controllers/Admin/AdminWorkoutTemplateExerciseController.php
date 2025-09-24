<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkoutTemplateExercise;
use App\Models\WorkoutTemplate;
use App\Models\Exercise;

class AdminWorkoutTemplateExerciseController extends Controller
{
     public function index(Request $request)
    {
        $search = $request->input('search');
        $templateFilter = $request->input('template_filter');
        $workoutTypeFilter = $request->input('workout_type_filter');
        $experienceLevelFilter = $request->input('experience_level_filter');

        $exercises = WorkoutTemplateExercise::with(['template.workoutType', 'template.experienceLevel', 'exercise'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    // Search in exercise names
                    $q->whereHas('exercise', function ($exerciseQuery) use ($search) {
                        $exerciseQuery->where('name', 'like', "%$search%");
                    })
                    // Also search in template names
                    ->orWhereHas('template', function ($templateQuery) use ($search) {
                        $templateQuery->where('name', 'like', "%$search%");
                    });
                });
            })
            ->when($templateFilter, function ($query) use ($templateFilter) {
                $query->where('template_id', $templateFilter);
            })
            ->when($workoutTypeFilter, function ($query) use ($workoutTypeFilter) {
                $query->whereHas('template', function ($q) use ($workoutTypeFilter) {
                    $q->where('workout_type_id', $workoutTypeFilter);
                });
            })
            ->when($experienceLevelFilter, function ($query) use ($experienceLevelFilter) {
                $query->whereHas('template', function ($q) use ($experienceLevelFilter) {
                    $q->where('experience_level_id', $experienceLevelFilter);
                });
            })
            ->orderBy('template_id')
            ->orderBy('order_in_workout')
            ->paginate(15);

        // Get filter options
        $templates = WorkoutTemplate::with(['workoutType', 'experienceLevel'])->get();
        $workoutTypes = \App\Models\WorkoutType::all();
        $experienceLevels = \App\Models\ExperienceLevel::all();

        return view('admin.workout-builder.index', [
            'exercises' => $exercises,
            'search' => $search,
            'templateFilter' => $templateFilter,
            'workoutTypeFilter' => $workoutTypeFilter,
            'experienceLevelFilter' => $experienceLevelFilter,
            'templates' => $templates,
            'workoutTypes' => $workoutTypes,
            'experienceLevels' => $experienceLevels,
            'allExercises' => Exercise::all(),
            'editing' => null
        ]);
    }

  

    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:workout_templates,id',
            'exercise_id' => 'required|exists:exercises,id',
            'sets' => 'required|integer',
            'reps' => 'required|string',
            'duration_seconds' => 'nullable|integer',
            'rest_seconds' => 'required|integer',
            'order_in_workout' => 'required|integer',
        ]);

        WorkoutTemplateExercise::create($request->all());

         return redirect()->route('workout-template-exercises.index')->with('success', 'Exercise added to template.');
    }



    public function update(Request $request, WorkoutTemplateExercise $workout_template_exercise)
    {
        $request->validate([
            'template_id' => 'required|exists:workout_templates,id',
            'exercise_id' => 'required|exists:exercises,id',
            'sets' => 'required|integer',
            'reps' => 'required|string',
            'duration_seconds' => 'nullable|integer',
            'rest_seconds' => 'required|integer',
            'order_in_workout' => 'required|integer',
        ]);

        $workout_template_exercise->update($request->all());

        return redirect()->route('workout-template-exercises.index')->with('success', 'Exercise updated.');
    }

    public function destroy(WorkoutTemplateExercise $workout_template_exercise)
    {
        $workout_template_exercise->delete();

        return redirect()->back()->with('success', 'Exercise removed from template.');
    }
}
