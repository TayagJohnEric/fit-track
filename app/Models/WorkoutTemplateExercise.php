<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class WorkoutTemplateExercise extends Pivot
{
    protected $table = 'workout_template_exercises';

    protected $fillable = [
        'template_id',
        'exercise_id',
        'sets',
        'reps',
        'duration_seconds',
        'rest_seconds',
        'order_in_workout',
    ];

    public $timestamps = true;

    public function template()
    {
        return $this->belongsTo(WorkoutTemplate::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
