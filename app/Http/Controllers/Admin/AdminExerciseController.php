<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercise;


class AdminExerciseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $exercises = Exercise::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('muscle_group', 'like', "%{$search}%")
                         ->orWhere('equipment_needed', 'like', "%{$search}%");
        })->latest()->paginate(12);

        return view('admin.exercises.index', compact('exercises', 'search'));
    }

    public function create()
    {
        return view('admin.exercises.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'muscle_group' => 'required',
            'equipment_needed' => 'required',
            'video_url' => 'nullable|url',
        ]);

        Exercise::create($request->all());

        return redirect()->route('exercises.index')->with('success', 'Exercise created successfully.');
    }

    public function edit(Exercise $exercise)
    {
        return view('admin.exercises.edit', compact('exercise'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'muscle_group' => 'required',
            'equipment_needed' => 'required',
            'video_url' => 'nullable|url',
        ]);

        $exercise->update($request->all());

        return redirect()->route('exercises.index')->with('success', 'Exercise updated successfully.');
    }

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect()->route('exercises.index')->with('success', 'Exercise deleted successfully.');
    }
}
