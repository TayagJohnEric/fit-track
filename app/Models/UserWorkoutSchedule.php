<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWorkoutSchedule extends Model
{
    protected $table = 'user_workout_schedules';
    
    protected $fillable = [
        'user_id',
        'template_id',
        'assigned_date',
        'status',
        'completion_date',
        'skipped_date',
        'user_notes',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'status' => 'string',
        'completion_date' => 'datetime',
        'skipped_date' => 'datetime',
    ];

    // One-to-Many (Inverse): UserWorkoutSchedule belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One-to-Many (Inverse): UserWorkoutSchedule belongs to WorkoutTemplate
    public function workoutTemplate()
    {
        return $this->belongsTo(WorkoutTemplate::class, 'template_id');
    }
}
