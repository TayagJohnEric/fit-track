<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
     protected $table = 'food_items';
    
    protected $fillable = [
        'creator_user_id',
        'name',
        'serving_size_description',
        'serving_size_grams',
        'calories_per_serving',
        'protein_grams_per_serving',
        'carb_grams_per_serving',
        'fat_grams_per_serving',
        'estimated_cost',
        'image_url',
    ];

    protected $casts = [
        'protein_grams_per_serving' => 'decimal:1',
        'carb_grams_per_serving' => 'decimal:1',
        'fat_grams_per_serving' => 'decimal:1',
        'estimated_cost' => 'decimal:2',
    ];

    // One-to-Many (Inverse): FoodItem belongs to User (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    // One-to-Many: FoodItem has many UserMealLogEntries
    public function mealLogEntries()
    {
        return $this->hasMany(UserMealLogEntry::class);
    }

    // Many-to-Many: FoodItem has many Allergies
    public function allergies()
    {
        return $this->belongsToMany(Allergy::class, 'food_item_allergies')
                    ->withTimestamps();
    }
}
