<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    protected $table = 'allergies';
    
    protected $fillable = ['name'];

    // Many-to-Many: Allergy belongs to many Users
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_allergies')
                    ->withTimestamps();
    }

    // Many-to-Many: Allergy belongs to many FoodItems
    public function foodItems()
    {
        return $this->belongsToMany(FoodItem::class, 'food_item_allergies')
                    ->withTimestamps();
    }
}
