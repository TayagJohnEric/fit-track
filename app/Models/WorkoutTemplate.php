<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutTemplate extends Model
{
   protected $table = 'workout_templates';
    
    protected $fillable = [
        'name',
        'description',
        'workout_type_id',
        'experience_level_id',
        'duration_minutes',
        'difficulty_level',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'difficulty_level' => 'integer',
    ];

    // One-to-Many: WorkoutTemplate has many UserWorkoutSchedules
    public function workoutSchedules()
    {
        return $this->hasMany(UserWorkoutSchedule::class, 'template_id');
    }

    // One-to-Many (Inverse): WorkoutTemplate belongs to ExperienceLevel
    public function experienceLevel()
    {
        return $this->belongsTo(ExperienceLevel::class);
    }

    // One-to-Many (Inverse): WorkoutTemplate belongs to WorkoutType
    public function workoutType()
    {
        return $this->belongsTo(WorkoutType::class);
    }

    // Many-to-Many: WorkoutTemplate has many Exercises
  public function exercises()
{
    return $this->belongsToMany(Exercise::class, 'workout_template_exercises', 'template_id', 'exercise_id')
                ->withPivot([
                    'sets', 'reps', 'duration_seconds',
                    'rest_seconds', 'order_in_workout'
                ])
                ->withTimestamps()
                ->orderBy('workout_template_exercises.order_in_workout');
}

}
