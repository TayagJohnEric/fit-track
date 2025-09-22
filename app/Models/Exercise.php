<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Exercise extends Model
{
    protected $table = 'exercises';
    
    protected $fillable = [
        'name',
        'description',
        'muscle_group',
        'equipment_needed',
        'video_url',
        'image_url', // Added for YouTube thumbnail or custom image
    ];

    /**
     * Accessor to always return a fully-qualified image URL.
     * - If value is a YouTube URL, convert to thumbnail URL.
     * - If value is an absolute URL, return as-is.
     * - If value is a storage-relative path, convert via Storage::url().
     */
    public function getImageUrlAttribute($value)
    {
        if (empty($value)) {
            // Fallback: derive YouTube thumbnail from video_url if available
            if (!empty($this->video_url)) {
                if (preg_match('/(?:youtu\\.be\\/|youtube\\.com\\/(?:embed\\/|v\\/|watch\\?v=))([\\w-]{11})/i', $this->video_url, $matches)) {
                    return "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
                }
            }
            return null;
        }

        // Check if the value is a YouTube URL and convert to thumbnail
        if (Str::startsWith($value, ['http://', 'https://'])) {
            // Extract YouTube video ID from various YouTube URL formats
            if (preg_match('/(?:youtu\\.be\\/|youtube\\.com\\/(?:embed\\/|v\\/|watch\\?v=))([\\w-]{11})/i', $value, $matches)) {
                return "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
            }
            // If it's not a YouTube URL, return as-is (for other image URLs)
            return $value;
        }

        return Storage::url($value);
    }

    // Many-to-Many: Exercise belongs to many WorkoutTemplates
   public function templates()
{
    return $this->belongsToMany(WorkoutTemplate::class, 'workout_template_exercises', 'exercise_id', 'template_id')
        ->using(WorkoutTemplateExercise::class)
        ->withPivot([
            'sets', 'reps', 'duration_seconds', 'rest_seconds', 'order_in_workout'
        ])
        ->withTimestamps();
}


}
