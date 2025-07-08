<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FoodItem;


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

    public function create()
    {
        return view('admin.food-items.create');
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
            'image_url' => 'nullable|url'
        ]);

        $validated['creator_user_id'] = auth()->id();

        FoodItem::create($validated);

        return redirect()->route('food_items.index')->with('success', 'Food item added successfully.');
    }

    public function edit(FoodItem $food_item)
    {
        return view('admin.food-items.edit', compact('food_item'));
    }

    public function update(Request $request, FoodItem $food_item)
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
            'image_url' => 'nullable|url'
        ]);

        $food_item->update($validated);

        return redirect()->route('food_items.index')->with('success', 'Food item updated.');
    }

    public function destroy(FoodItem $food_item)
    {
        $food_item->delete();

        return redirect()->route('food_items.index')->with('success', 'Food item deleted.');
    }
}
