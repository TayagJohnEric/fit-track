<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use App\Models\User;
use App\Models\UserMealLog;
use App\Models\UserMealLogEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserMealIdeasController extends Controller
{
    /**
 * Display the meal ideas form and results
 */
public function index(Request $request)
{
    $user = Auth::user();
    $userProfile = $user->userProfile;
    
    // Get user's default budget from profile or set a default
    $defaultBudget = $userProfile->daily_budget ?? 100.00;
    
    $mealIdeas = null;
    $budget = null;
    
    if ($request->has('budget') && $request->budget > 0) {
        $budget = $request->budget;
        $mealIdeas = $this->generateMealIdeas($budget, $user);
        
        // Handle AJAX requests
        if ($request->has('ajax') || $request->ajax()) {
            return response()->json([
                'mealIdeas' => $mealIdeas,
                'budget' => $budget,
                'success' => true
            ]);
        }
    }
    
    return view('user.meal-ideas.index', compact('mealIdeas', 'budget', 'defaultBudget'));
}
    
    /**
     * Display meal details on a separate page
     */
    public function show(Request $request)
    {
        $itemIds = $request->input('items', []);
        // Normalize `items` to an array (links pass comma-separated ids)
        if (is_string($itemIds)) {
            $itemIds = array_filter(array_map('intval', explode(',', $itemIds)));
        }
        $budget = $request->input('budget', 0);
        
        // Validate that we have item IDs
        if (empty($itemIds)) {
            return redirect()->route('meal-ideas.index')
                ->with('error', 'No meal items selected.');
        }
        
        // Get the food items
        $items = FoodItem::whereIn('id', $itemIds)->get();
        
        if ($items->isEmpty()) {
            return redirect()->route('meal-ideas.index')
                ->with('error', 'Selected meal items not found.');
        }
        
        // Calculate totals
        $totals = [
            'cost' => $items->sum('estimated_cost'),
            'calories' => $items->sum('calories_per_serving'),
            'protein' => $items->sum('protein_grams_per_serving'),
            'carbs' => $items->sum('carb_grams_per_serving'),
            'fats' => $items->sum('fat_grams_per_serving'),
        ];
        
        return view('user.meal-ideas.show', compact('items', 'totals', 'budget'));
    }
    
    /**
     * Handle logging a meal from meal ideas
     */
    public function logMeal(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*' => 'exists:food_items,id',
            'meal_type' => 'required|in:Breakfast,Lunch,Dinner,Snack',
            'log_date' => 'required|date',
            'quantities' => 'array',
            'quantities.*' => 'numeric|min:0.01',
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
            foreach ($request->items as $index => $foodItemId) {
                $quantity = $request->quantities[$index] ?? 1; // Default to 1 serving
                
                UserMealLogEntry::create([
                    'meal_log_id' => $mealLog->id,
                    'food_item_id' => $foodItemId,
                    'quantity_consumed' => $quantity,
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
     * Show the log meal form for meal ideas
     */
    public function showLogForm(Request $request)
    {
        $itemIds = $request->input('items', []);
        // Normalize `items` to an array (links pass comma-separated ids)
        if (is_string($itemIds)) {
            $itemIds = array_filter(array_map('intval', explode(',', $itemIds)));
        }
        $budget = $request->input('budget', 0);
        
        // Validate that we have item IDs
        if (empty($itemIds)) {
            return redirect()->route('meal-ideas.index')
                ->with('error', 'No meal items selected.');
        }
        
        // Get the food items
        $items = FoodItem::whereIn('id', $itemIds)->get();
        
        if ($items->isEmpty()) {
            return redirect()->route('meal-ideas.index')
                ->with('error', 'Selected meal items not found.');
        }
        
        // Calculate totals
        $totals = [
            'cost' => $items->sum('estimated_cost'),
            'calories' => $items->sum('calories_per_serving'),
            'protein' => $items->sum('protein_grams_per_serving'),
            'carbs' => $items->sum('carb_grams_per_serving'),
            'fats' => $items->sum('fat_grams_per_serving'),
        ];
        
        return view('user.meal-ideas.log-form', compact('items', 'totals', 'budget'));
    }
    
    /**
 * Generate meal ideas based on budget and user allergies
 */
private function generateMealIdeas($budget, $user)
{
    // Get user's allergies
    $userAllergies = $user->allergies->pluck('id')->toArray();
    
    // Get food items that fit the budget and don't contain user's allergies
    $availableFoodItems = FoodItem::where('estimated_cost', '<=', $budget)
        ->whereDoesntHave('allergies', function ($query) use ($userAllergies) {
            $query->whereIn('allergy_id', $userAllergies);
        })
        ->orderBy('estimated_cost', 'asc')
        ->get();
    
    if ($availableFoodItems->isEmpty()) {
        return [];
    }
    
    // Generate balanced meal combinations
    $mealCombinations = $this->createMealCombinations($availableFoodItems, $budget);
    
    return $mealCombinations;
}

    
   /**
 * Create balanced meal combinations within budget
 */
private function createMealCombinations($foodItems, $budget)
{
    $combinations = [];
    
    // Group food items by type (simple categorization based on macros)
    $proteins = $foodItems->filter(function ($item) {
        return $item->protein_grams_per_serving >= 15;
    });
    
    $carbs = $foodItems->filter(function ($item) {
        return $item->carb_grams_per_serving >= 20 && $item->protein_grams_per_serving < 15;
    });
    
    $others = $foodItems->filter(function ($item) {
        return $item->protein_grams_per_serving < 15 && $item->carb_grams_per_serving < 20;
    });
    
    // Generate combinations (protein + carb + optional other)
    foreach ($proteins->take(5) as $protein) {
        foreach ($carbs->take(3) as $carb) {
            $currentCost = $protein->estimated_cost + $carb->estimated_cost;
            
            if ($currentCost <= $budget) {
                $combination = [
                    'items' => [$protein, $carb],
                    'total_cost' => $currentCost,
                    'total_calories' => $protein->calories_per_serving + $carb->calories_per_serving,
                    'total_protein' => $protein->protein_grams_per_serving + $carb->protein_grams_per_serving,
                    'total_carbs' => $protein->carb_grams_per_serving + $carb->carb_grams_per_serving,
                    'total_fats' => $protein->fat_grams_per_serving + $carb->fat_grams_per_serving,
                ];
                
                // Try to add a third item if budget allows
                foreach ($others->take(2) as $other) {
                    if ($currentCost + $other->estimated_cost <= $budget) {
                        $enhancedCombination = [
                            'items' => [$protein, $carb, $other],
                            'total_cost' => $currentCost + $other->estimated_cost,
                            'total_calories' => $combination['total_calories'] + $other->calories_per_serving,
                            'total_protein' => $combination['total_protein'] + $other->protein_grams_per_serving,
                            'total_carbs' => $combination['total_carbs'] + $other->carb_grams_per_serving,
                            'total_fats' => $combination['total_fats'] + $other->fat_grams_per_serving,
                        ];
                        $combinations[] = $enhancedCombination;
                        break;
                    }
                }
                
                $combinations[] = $combination;
            }
        }
    }
    
    // Also add simple single-item or two-item combinations
    foreach ($foodItems->take(10) as $item) {
        if ($item->estimated_cost <= $budget) {
            $combinations[] = [
                'items' => [$item],
                'total_cost' => $item->estimated_cost,
                'total_calories' => $item->calories_per_serving,
                'total_protein' => $item->protein_grams_per_serving,
                'total_carbs' => $item->carb_grams_per_serving,
                'total_fats' => $item->fat_grams_per_serving,
            ];
        }
    }
    
    // Sort by best value (calories per peso) and limit results
    usort($combinations, function ($a, $b) {
        $valueA = $a['total_calories'] / $a['total_cost'];
        $valueB = $b['total_calories'] / $b['total_cost'];
        return $valueB <=> $valueA;
    });
    
    return array_slice($combinations, 0, 12); // Return top 12 combinations
}
}