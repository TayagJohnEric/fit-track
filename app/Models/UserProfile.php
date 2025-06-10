<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'sex',
        'height_cm',
        'current_weight_kg',
        'daily_budget',
        'fitness_goal_id',
        'experience_level_id',
        'preferred_workout_type_id',
        'last_profile_update',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'sex' => 'string',
        'height_cm' => 'decimal:1',
        'current_weight_kg' => 'decimal:1',
        'daily_budget' => 'decimal:2',
        'last_profile_update' => 'datetime',
    ];

    // One-to-One: UserProfile belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One-to-Many (Inverse): UserProfile belongs to FitnessGoal
    public function fitnessGoal()
    {
        return $this->belongsTo(FitnessGoal::class);
    }

    // One-to-Many (Inverse): UserProfile belongs to ExperienceLevel
    public function experienceLevel()
    {
        return $this->belongsTo(ExperienceLevel::class);
    }

    // One-to-Many (Inverse): UserProfile belongs to WorkoutType
    public function preferredWorkoutType()
    {
        return $this->belongsTo(WorkoutType::class, 'preferred_workout_type_id');
    }
}
