<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutType extends Model
{
    protected $table = 'workout_types';
    
    protected $fillable = ['name'];

    // One-to-Many: WorkoutType has many UserProfiles
    public function userProfiles()
    {
        return $this->hasMany(UserProfile::class, 'preferred_workout_type_id');
    }

    // One-to-Many: WorkoutType has many WorkoutTemplates
    public function workoutTemplates()
    {
        return $this->hasMany(WorkoutTemplate::class);
    }
}
