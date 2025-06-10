<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNutritionGoal extends Model
{
    protected $table = 'user_nutrition_goals';
    
    protected $fillable = [
        'user_id',
        'target_calories',
        'target_protein_grams',
        'target_carb_grams',
        'target_fat_grams',
        'last_updated',
    ];

    protected $casts = [
        'last_updated' => 'datetime',
    ];

    // One-to-Many (Inverse): UserNutritionGoal belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
