<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Allergy;



class UserCustomFoodItemController extends Controller
{
    public function index()
    {
        $foods = FoodItem::where('creator_user_id', Auth::id())->paginate(10);

        return view('user.custom-food.index', compact('foods'));
    }

    public function edit(FoodItem $custom_food)
{
    $this->authorizeOwner($custom_food);
    
    // Get all allergies for the checkboxes
    $allergies = Allergy::all();
    
    // Load the food item with its allergies relationship
    $custom_food->load('allergies');
    
    return view('user.custom-food.edit', compact('custom_food', 'allergies'));
}

public function update(Request $request, FoodItem $custom_food)
{
    // Authorize that the user owns this custom food
    $this->authorizeOwner($custom_food);
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'serving_size_description' => 'required|string|max:255',
        'serving_size_grams' => 'required|integer|min:1',
        'calories_per_serving' => 'required|integer|min:0',
        'protein_grams_per_serving' => 'required|numeric|min:0',
        'carb_grams_per_serving' => 'required|numeric|min:0',
        'fat_grams_per_serving' => 'required|numeric|min:0',
        'estimated_cost' => 'required|numeric|min:0',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'remove_image' => 'nullable|boolean',
        'allergies' => 'array',
        'allergies.*' => 'exists:allergies,id',
    ]);

    DB::beginTransaction();
    
    try {
        $imagePath = $custom_food->image_url;

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($custom_food->image_url && Storage::disk('public')->exists($custom_food->image_url)) {
                Storage::disk('public')->delete($custom_food->image_url);
            }
            $imagePath = null;
        }
        
        // Handle new image upload
        if ($request->hasFile('image_url')) {
            // Delete old image if it exists
            if ($custom_food->image_url && Storage::disk('public')->exists($custom_food->image_url)) {
                Storage::disk('public')->delete($custom_food->image_url);
            }

            // Store new image
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('food-images', $imageName, 'public');
        }

        $validated['image_url'] = $imagePath;
        
        // Update the food item (preserve creator_user_id)
        $custom_food->update($validated);
        
        // Update allergies if provided
        if ($request->has('allergies')) {
            $custom_food->allergies()->sync($request->allergies);
        } else {
            // If no allergies selected, remove all associations
            $custom_food->allergies()->detach();
        }
        
        DB::commit();
        
        return redirect()
            ->route('custom-foods.index')
            ->with('success', 'Custom food updated successfully.');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Error updating food item. Please try again.')
            ->withInput();
    }
}


    
    public function destroy(FoodItem $custom_food)
    {
        $this->authorizeOwner($custom_food);

        $custom_food->delete();

        return redirect()
            ->route('custom-foods.index')
            ->with('success', 'Custom food deleted successfully.');
    }

    protected function authorizeOwner(FoodItem $food)
    {
        if ($food->creator_user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
