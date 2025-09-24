<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allergy;


class AdminAllergyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Allergy::query();

        // Handle search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Order by created_at desc and paginate
        $allergies = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.allergies.index', compact('allergies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:allergies,name',
        ], [
            'name.required' => 'The allergy name is required.',
            'name.unique' => 'This allergy already exists.',
            'name.max' => 'The allergy name must not exceed 255 characters.',
        ]);

        // Clean up the name (trim whitespace and convert to title case)
        $validated['name'] = trim($validated['name']);
        $validated['name'] = ucwords(strtolower($validated['name']));

        Allergy::create($validated);

        return redirect()->route('admin.allergies.index')
            ->with('success', 'Allergy "' . $validated['name'] . '" created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Allergy $allergy)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:allergies,name,' . $allergy->id,
        ], [
            'name.required' => 'The allergy name is required.',
            'name.unique' => 'This allergy already exists.',
            'name.max' => 'The allergy name must not exceed 255 characters.',
        ]);

        // Clean up the name (trim whitespace and convert to title case)
        $validated['name'] = trim($validated['name']);
        $validated['name'] = ucwords(strtolower($validated['name']));

        $oldName = $allergy->name;
        $allergy->update($validated);

        return redirect()->route('admin.allergies.index')
            ->with('success', 'Allergy "' . $oldName . '" updated to "' . $validated['name'] . '" successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Allergy $allergy)
    {
        // Check if allergy is associated with any users or food items
        $userCount = $allergy->users()->count();
        $foodItemCount = $allergy->foodItems()->count();

        if ($userCount > 0 || $foodItemCount > 0) {
            $errorMessage = 'Cannot delete allergy "' . $allergy->name . '": It is currently associated with ';
            
            if ($userCount > 0) {
                $errorMessage .= $userCount . ' user' . ($userCount > 1 ? 's' : '');
            }
            
            if ($userCount > 0 && $foodItemCount > 0) {
                $errorMessage .= ' and ';
            }
            
            if ($foodItemCount > 0) {
                $errorMessage .= $foodItemCount . ' food item' . ($foodItemCount > 1 ? 's' : '');
            }
            
            $errorMessage .= '. Please remove these associations before deleting.';

            return redirect()->route('admin.allergies.index')
                ->with('error', $errorMessage);
        }

        $allergyName = $allergy->name;
        $allergy->delete();

        return redirect()->route('admin.allergies.index')
            ->with('success', 'Allergy "' . $allergyName . '" deleted successfully.');
    }
}
