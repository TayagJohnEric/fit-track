<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMealLog extends Model
{
     protected $table = 'user_meal_logs';
    
    protected $fillable = [
        'user_id',
        'log_date',
        'meal_type',
    ];

    protected $casts = [
        'log_date' => 'date',
        'meal_type' => 'string',
    ];

    // One-to-Many (Inverse): UserMealLog belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One-to-Many: UserMealLog has many UserMealLogEntries
    public function mealLogEntries()
    {
        return $this->hasMany(UserMealLogEntry::class);
    }
}
