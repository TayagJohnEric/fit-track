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

        $exercises = WorkoutTemplateExercise::with(['template', 'exercise'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('exercise', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->orderBy('order_in_workout')
            ->paginate(10);

        return view('admin.workout-builder.index', [
            'exercises' => $exercises,
            'search' => $search,
            'templates' => WorkoutTemplate::all(),
            'allExercises' => Exercise::all(),
            'editing' => null
        ]);
    }

    public function create()
{
    return view('admin.workout-builder.create', [
        'templates' => WorkoutTemplate::all(),
        'allExercises' => Exercise::all()
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

    public function edit(WorkoutTemplateExercise $workout_template_exercise)
{
    return view('admin.workout-builder.edit', [
        'editing' => $workout_template_exercise,
        'templates' => WorkoutTemplate::all(),
        'allExercises' => Exercise::all()
    ]);
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
