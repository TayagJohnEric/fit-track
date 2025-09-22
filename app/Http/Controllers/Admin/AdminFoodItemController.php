<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FoodItem;
use Illuminate\Support\Facades\Storage;
    


class AdminFoodItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $foodItems = FoodItem::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('serving_size_description', 'like', "%{$search}%");
        })->latest()->paginate(12);

        return view('admin.food-items.index', compact('foodItems', 'search'));
    }

   

   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'serving_size_description' => 'required|string',
        'serving_size_grams' => 'required|integer',
        'calories_per_serving' => 'required|integer',
        'protein_grams_per_serving' => 'required|numeric',
        'carb_grams_per_serving' => 'required|numeric',
        'fat_grams_per_serving' => 'required|numeric',
        'estimated_cost' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('food_images', 'public');
    }

    $validated['image_url'] = $imagePath;
    // Admin-created foods are system foods available to all users
    $validated['creator_user_id'] = null;

    FoodItem::create($validated);

    return redirect()->route('food_items.index')->with('success', 'Food item added successfully.');
}
    

  public function update(Request $request, FoodItem $foodItem )
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'serving_size_description' => 'required|string',
        'serving_size_grams' => 'required|integer',
        'calories_per_serving' => 'required|integer',
        'protein_grams_per_serving' => 'required|numeric',
        'carb_grams_per_serving' => 'required|numeric',
        'fat_grams_per_serving' => 'required|numeric',
        'estimated_cost' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = $foodItem->image_url;

    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($foodItem->image_url && Storage::disk('public')->exists($foodItem->image_url)) {
            Storage::disk('public')->delete($foodItem->image_url);
        }

        // Store new image
        $imagePath = $request->file('image')->store('food_images', 'public');
    }

    $validated['image_url'] = $imagePath;
    // Preserve the original creator_user_id when updating
    // Don't change ownership of existing foods
    
    $foodItem->update($validated);

    return redirect()->route('food_items.index')->with('success', 'Food item updated successfully.');
}
    public function destroy(FoodItem $foodItem)
    {
        $foodItem->delete();

        return redirect()->route('food_items.index')->with('success', 'Food item deleted.');
    }
}
