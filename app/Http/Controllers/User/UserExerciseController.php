<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserExerciseController extends Controller
{
    /**
     * Display a paginated list of exercises with optional search and filtering
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get search parameters from request
        $search = $request->get('search', '');
        $muscleGroup = $request->get('muscle_group', '');
        $equipment = $request->get('equipment', '');
        $perPage = $request->get('per_page', 12); // Default 12 exercises per page

        // Build the query with optional filters
        $query = Exercise::query();

        // Apply search filter if provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('muscle_group', 'LIKE', "%{$search}%")
                  ->orWhere('equipment_needed', 'LIKE', "%{$search}%");
            });
        }

        // Apply muscle group filter if provided
        if (!empty($muscleGroup)) {
            $query->where('muscle_group', 'LIKE', "%{$muscleGroup}%");
        }

        // Apply equipment filter if provided
        if (!empty($equipment)) {
            $query->where('equipment_needed', 'LIKE', "%{$equipment}%");
        }

        // Get paginated results ordered by name
        $exercises = $query->orderBy('name', 'asc')->paginate($perPage);

        // Get unique muscle groups and equipment for filter dropdowns
        $muscleGroups = Exercise::distinct()->pluck('muscle_group')->filter()->sort()->values();
        $equipmentTypes = Exercise::distinct()->pluck('equipment_needed')->filter()->sort()->values();

        return view('user.exercises.index', compact(
            'exercises', 
            'search', 
            'muscleGroup', 
            'equipment', 
            'muscleGroups', 
            'equipmentTypes'
        ));
    }

    /**
     * AJAX endpoint for searching exercises
     * Returns JSON response for dynamic search functionality
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        // Validate request parameters
        $request->validate([
            'search' => 'nullable|string|max:255',
            'muscle_group' => 'nullable|string|max:100',
            'equipment' => 'nullable|string|max:100',
            'per_page' => 'nullable|integer|min:6|max:50'
        ]);

        // Get search parameters
        $search = $request->get('search', '');
        $muscleGroup = $request->get('muscle_group', '');
        $equipment = $request->get('equipment', '');
        $perPage = $request->get('per_page', 12);

        // Build query with filters
        $query = Exercise::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('muscle_group', 'LIKE', "%{$search}%")
                  ->orWhere('equipment_needed', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($muscleGroup)) {
            $query->where('muscle_group', 'LIKE', "%{$muscleGroup}%");
        }

        if (!empty($equipment)) {
            $query->where('equipment_needed', 'LIKE', "%{$equipment}%");
        }

        // Get paginated results
        $exercises = $query->orderBy('name', 'asc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $exercises->items(),
            'pagination' => [
                'current_page' => $exercises->currentPage(),
                'last_page' => $exercises->lastPage(),
                'per_page' => $exercises->perPage(),
                'total' => $exercises->total(),
                'from' => $exercises->firstItem(),
                'to' => $exercises->lastItem()
            ]
        ]);
    }

    /**
     * Display detailed view of a specific exercise
     * 
     * @param Exercise $exercise
     * @return \Illuminate\View\View
     */
    public function show(Exercise $exercise)
    {
        // Load related workout templates that use this exercise
        $workoutTemplates = $exercise->templates()
            ->with(['experienceLevel', 'workoutType'])
            ->take(5) // Limit to 5 related templates
            ->get();

        return view('user.exercises.show', compact('exercise', 'workoutTemplates'));
    }

    /**
     * Get exercise details via AJAX
     * Used for modal or quick preview functionality
     * 
     * @param Exercise $exercise
     * @return JsonResponse
     */
    public function getDetails(Exercise $exercise): JsonResponse
    {
        // Load related templates with minimal data for performance
        $relatedTemplates = $exercise->templates()
            ->select('id', 'name', 'duration_minutes', 'difficulty_level')
            ->take(3)
            ->get();

        return response()->json([
            'success' => true,
            'exercise' => [
                'id' => $exercise->id,
                'name' => $exercise->name,
                'description' => $exercise->description,
                'muscle_group' => $exercise->muscle_group,
                'equipment_needed' => $exercise->equipment_needed,
                'video_url' => $exercise->video_url,
                'image_url' => $exercise->image_url,
                'related_templates' => $relatedTemplates
            ]
        ]);
    }

    /**
     * Get exercises by muscle group (AJAX endpoint)
     * Useful for filtering exercises in workout builders
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getByMuscleGroup(Request $request): JsonResponse
    {
        $request->validate([
            'muscle_group' => 'required|string|max:100'
        ]);

        $muscleGroup = $request->get('muscle_group');

        $exercises = Exercise::where('muscle_group', 'LIKE', "%{$muscleGroup}%")
            ->select('id', 'name', 'muscle_group', 'equipment_needed')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'exercises' => $exercises,
            'count' => $exercises->count()
        ]);
    }
}
