<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserMealLog;
use App\Models\UserMealLogEntry;
use App\Models\FoodItem;
use App\Models\Allergy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class UserMealLogController extends Controller
{
    /**
     * Display the meal logging interface
     */
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        // Get today's meal logs for the user
        $todaysMealLogs = UserMealLog::where('user_id', $user->id)
            ->where('log_date', $today)
            ->with(['mealLogEntries.foodItem'])
            ->get()
            ->groupBy('meal_type');
        
        // Calculate today's totals
        $todaysTotals = $this->calculateDailyTotals($user->id, $today);
        
        return view('user.log-meal.index', compact('todaysMealLogs', 'todaysTotals'));
    }

    /**
     * Show the form for creating a new meal log
     */
    public function create(Request $request)
    {
        
        $mealType = $request->get('meal_type', 'Breakfast');
        $logDate = $request->get('log_date', Carbon::today()->toDateString());
        
        // Get user allergies for food filtering
        $userAllergies = Auth::user()->allergies()->pluck('allergies.id')->toArray();
        
        return view('user.log-meal.create', compact('mealType', 'logDate', 'userAllergies'));
    }

    /**
     * Store a newly created meal log
     */
    public function store(Request $request)
    {
        $request->validate([
            'meal_type' => 'required|in:Breakfast,Lunch,Dinner,Snack',
            'log_date' => 'required|date',
            'food_items' => 'required|array|min:1',
            'food_items.*.id' => 'required|exists:food_items,id',
            'food_items.*.quantity' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();
        
        try {
            // Create or find existing meal log
            $mealLog = UserMealLog::firstOrCreate([
                'user_id' => Auth::id(),
                'log_date' => $request->log_date,
                'meal_type' => $request->meal_type,
            ]);

            // Add food items to the meal log
            foreach ($request->food_items as $foodItem) {
                UserMealLogEntry::create([
                    'meal_log_id' => $mealLog->id,
                    'food_item_id' => $foodItem['id'],
                    'quantity_consumed' => $foodItem['quantity'],
                ]);
            }

            DB::commit();
            
            return redirect()->route('nutrition.index')
                ->with('success', 'Meal logged successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error logging meal. Please try again.')
                ->withInput();
        }
    }

    /**
     * Search for food items via AJAX
     */
    public function searchFoodItems(Request $request)
    {
        $query = $request->get('query');
        $userAllergies = Auth::user()->allergies()->pluck('allergies.id')->toArray();
        
        $foodItems = FoodItem::where(function($q) {
                $q->whereNull('creator_user_id')
                  ->orWhere('creator_user_id', Auth::id());
            })
            ->where('name', 'LIKE', "%{$query}%")
            ->with('allergies')
            ->limit(10)
            ->get();

        // Check for allergy warnings
        $foodItems = $foodItems->map(function($item) use ($userAllergies) {
            $itemAllergies = $item->allergies->pluck('id')->toArray();
            $item->has_allergy_warning = !empty(array_intersect($userAllergies, $itemAllergies));
            $item->allergy_names = $item->allergies->pluck('name')->toArray();
            return $item;
        });

        return response()->json($foodItems);
    }

    /**
     * Show form to create custom food item
     */
    public function createCustomFood()
    {
        $allergies = Allergy::all();
        return view('user.log-meal.create-custom-food', compact('allergies'));
    }

    /**
     * Store custom food item
     */
    public function storeCustomFood(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'serving_size_description' => 'required|string|max:255',
            'serving_size_grams' => 'required|integer|min:1',
            'calories_per_serving' => 'required|integer|min:0',
            'protein_grams_per_serving' => 'required|numeric|min:0',
            'carb_grams_per_serving' => 'required|numeric|min:0',
            'fat_grams_per_serving' => 'required|numeric|min:0',
            'estimated_cost' => 'required|numeric|min:0',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'allergies' => 'array',
            'allergies.*' => 'exists:allergies,id',
        ]);

        DB::beginTransaction();
        
        try {
            // Handle image upload
            $imageUrl = null;
            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('food-images', $imageName, 'public');
                $imageUrl =  $imagePath;
            }
            
            $foodItem = FoodItem::create([
                'creator_user_id' => Auth::id(),
                'name' => $request->name,
                'serving_size_description' => $request->serving_size_description,
                'serving_size_grams' => $request->serving_size_grams,
                'calories_per_serving' => $request->calories_per_serving,
                'protein_grams_per_serving' => $request->protein_grams_per_serving,
                'carb_grams_per_serving' => $request->carb_grams_per_serving,
                'fat_grams_per_serving' => $request->fat_grams_per_serving,
                'estimated_cost' => $request->estimated_cost,
                'image_url' => $imageUrl,
            ]);

            // Attach allergies if any
            if ($request->allergies) {
                $foodItem->allergies()->attach($request->allergies);
            }

            DB::commit();
            
            return redirect()->route('nutrition.create')
                ->with('success', 'Custom food item created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating food item. Please try again.')
                ->withInput();
        }
    }

    /**
     * Delete a meal log entry
     */
    public function destroyEntry($entryId)
    {
        $entry = UserMealLogEntry::findOrFail($entryId);
        
        // Check if user owns this entry
        if ($entry->mealLog->user_id !== Auth::id()) {
            abort(403);
        }
        
        $entry->delete();
        
        // Check if meal log is empty and delete it
        if ($entry->mealLog->mealLogEntries()->count() === 0) {
            $entry->mealLog->delete();
        }
        
        return redirect()->route('nutrition.index')
            ->with('success', 'Food item removed from meal log.');
    }

    /**
     * Calculate daily nutrition totals
     */
    private function calculateDailyTotals($userId, $date)
    {
        $entries = UserMealLogEntry::whereHas('mealLog', function($query) use ($userId, $date) {
            $query->where('user_id', $userId)
                  ->where('log_date', $date);
        })->with('foodItem')->get();

        $totals = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
            'cost' => 0,
        ];

        foreach ($entries as $entry) {
            $quantity = $entry->quantity_consumed;
            $food = $entry->foodItem;
            
            $totals['calories'] += $food->calories_per_serving * $quantity;
            $totals['protein'] += $food->protein_grams_per_serving * $quantity;
            $totals['carbs'] += $food->carb_grams_per_serving * $quantity;
            $totals['fat'] += $food->fat_grams_per_serving * $quantity;
            $totals['cost'] += $food->estimated_cost * $quantity;
        }

        return $totals;
    }
}
