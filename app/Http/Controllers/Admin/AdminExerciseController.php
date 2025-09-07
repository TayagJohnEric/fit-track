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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'muscle_group' => 'required',
            'equipment_needed' => 'required',
            'video_url' => 'nullable|url',
            'image_url' => 'nullable|url',
        ]);

        $imageUrl = $request->image_url;
        if (!$imageUrl && $request->video_url) {
            $imageUrl = $this->getYoutubeThumbnail($request->video_url);
        }

        Exercise::create([
            'name' => $request->name,
            'description' => $request->description,
            'muscle_group' => $request->muscle_group,
            'equipment_needed' => $request->equipment_needed,
            'video_url' => $request->video_url,
            'image_url' => $imageUrl,
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
            'video_url' => 'nullable|url',
            'image_url' => 'nullable|url',
        ]);

        $imageUrl = $request->image_url;
        if (!$imageUrl && $request->video_url) {
            $imageUrl = $this->getYoutubeThumbnail($request->video_url);
        }

        $exercise->update([
            'name' => $request->name,
            'description' => $request->description,
            'muscle_group' => $request->muscle_group,
            'equipment_needed' => $request->equipment_needed,
            'video_url' => $request->video_url,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('exercises.index')->with('success', 'Exercise updated successfully.');
    }

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect()->route('exercises.index')->with('success', 'Exercise deleted successfully.');
    }

    /**
     * Extract YouTube video ID and return thumbnail URL
     */
    private function getYoutubeThumbnail($url)
    {
        preg_match(
            '/(?:youtu\\.be\\/|youtube\\.com\\/(?:embed\\/|v\\/|watch\\?v=))([\\w-]{11})/i',
            $url,
            $matches
        );

        return $matches[1] ?? null ? "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg" : null;
    }
}
