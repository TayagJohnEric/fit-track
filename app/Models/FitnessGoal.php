<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessGoal extends Model
{
    protected $table = 'fitness_goals';
    
    protected $fillable = ['name'];

    // One-to-Many: FitnessGoal has many UserProfiles
    public function userProfiles()
    {
        return $this->hasMany(UserProfile::class);
    }
}
