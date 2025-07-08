<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercises';
    
    protected $fillable = [
        'name',
        'description',
        'muscle_group',
        'equipment_needed',
        'video_url',
    ];

    // Many-to-Many: Exercise belongs to many WorkoutTemplates
    public function templates()
{
    return $this->belongsToMany(WorkoutTemplate::class, 'workout_template_exercises')
        ->using(WorkoutTemplateExercise::class)
        ->withPivot([
            'sets', 'reps', 'duration_seconds', 'rest_seconds', 'order_in_workout'
        ])
        ->withTimestamps();
}

}
