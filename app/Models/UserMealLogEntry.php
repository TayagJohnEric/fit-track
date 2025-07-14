<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMealLogEntry extends Model
{
    protected $table = 'user_meal_log_entries';
    
    protected $fillable = [
        'meal_log_id',
        'food_item_id',
        'quantity_consumed',
    ];

    protected $casts = [
        'quantity_consumed' => 'decimal:2',
    ];

  public function mealLog()
{
    return $this->belongsTo(UserMealLog::class, 'meal_log_id');
}

public function foodItem()
{
    return $this->belongsTo(FoodItem::class, 'food_item_id');
}
}
