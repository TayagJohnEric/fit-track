<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercise;
use Illuminate\Support\Facades\Storage;



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


   public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'muscle_group' => 'required',
        'equipment_needed' => 'required',
        'video' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200', // max 50MB
    ]);

    $videoPath = null;

    if ($request->hasFile('video')) {
        $videoPath = $request->file('video')->store('videos', 'public');
    }

    Exercise::create([
        'name' => $request->name,
        'description' => $request->description,
        'muscle_group' => $request->muscle_group,
        'equipment_needed' => $request->equipment_needed,
        'video_url' => $videoPath, // stored path
    ]);

    return redirect()->route('exercises.index')->with('success', 'Exercise created successfully.');
}

  public function update(Request $request, Exercise $exercise)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'muscle_group' => 'required',
        'equipment_needed' => 'required',
        'video' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200',
    ]);

    $videoPath = $exercise->video_url;

    if ($request->hasFile('video')) {
        // Optional: delete old video file if exists
        if ($exercise->video_url && Storage::disk('public')->exists($exercise->video_url)) {
            Storage::disk('public')->delete($exercise->video_url);
        }

        $videoPath = $request->file('video')->store('videos', 'public');
    }

    $exercise->update([
        'name' => $request->name,
        'description' => $request->description,
        'muscle_group' => $request->muscle_group,
        'equipment_needed' => $request->equipment_needed,
        'video_url' => $videoPath,
    ]);

    return redirect()->route('exercises.index')->with('success', 'Exercise updated successfully.');
}

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect()->route('exercises.index')->with('success', 'Exercise deleted successfully.');
    }
}
