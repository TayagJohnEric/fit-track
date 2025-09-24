<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use App\Models\Allergy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminFoodItemAllergyController extends Controller
{
    public function index(Request $request)
    {
        $query = FoodItem::with(['allergies', 'creator']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('allergies', function ($allergyQuery) use ($searchTerm) {
                      $allergyQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        $foodItems = $query->orderBy('name')->paginate(10);
        $allergies = Allergy::orderBy('name')->get();

        return view('admin.food-allergies.index', compact('foodItems', 'allergies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'food_item_id' => 'required|exists:food_items,id',
            'allergy_ids' => 'required|array|min:1',
            'allergy_ids.*' => 'exists:allergies,id'
        ]);

        $foodItem = FoodItem::findOrFail($request->food_item_id);
        
        // Sync the allergies (this will add new ones and keep existing ones)
        $currentAllergyIds = $foodItem->allergies()->pluck('allergies.id')->toArray();
        $newAllergyIds = array_unique(array_merge($currentAllergyIds, $request->allergy_ids));
        
        $foodItem->allergies()->sync($newAllergyIds);

        return redirect()->route('admin.food_item_allergies.index')
                         ->with('success', 'Food item allergies updated successfully!');
    }

    public function update(Request $request, $foodItemId)
    {
        $request->validate([
            'allergy_ids' => 'required|array|min:1',
            'allergy_ids.*' => 'exists:allergies,id'
        ]);

        $foodItem = FoodItem::findOrFail($foodItemId);
        $foodItem->allergies()->sync($request->allergy_ids);

        return redirect()->route('admin.food_item_allergies.index')
                         ->with('success', 'Food item allergies updated successfully!');
    }

    public function destroy($foodItemId)
    {
        $foodItem = FoodItem::findOrFail($foodItemId);
        $foodItem->allergies()->detach();

        return redirect()->route('admin.food_item_allergies.index')
                         ->with('success', 'All allergies removed from food item successfully!');
    }

}
