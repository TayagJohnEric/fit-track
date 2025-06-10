<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceLevel extends Model
{
     protected $table = 'experience_levels';
    
    protected $fillable = ['name'];

    // One-to-Many: ExperienceLevel has many UserProfiles
    public function userProfiles()
    {
        return $this->hasMany(UserProfile::class);
    }

    // One-to-Many: ExperienceLevel has many WorkoutTemplates
    public function workoutTemplates()
    {
        return $this->hasMany(WorkoutTemplate::class);
    }
}
