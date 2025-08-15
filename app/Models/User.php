<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'profile_image_url',
        'role',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // One-to-One: User has one UserProfile
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }

    // One-to-Many: User has many WeightHistory records
    public function weightHistory()
    {
        return $this->hasMany(WeightHistory::class);
    }

    // One-to-Many: User has many UserNutritionGoals
    public function nutritionGoals()
    {
        return $this->hasMany(UserNutritionGoal::class);
    }

    // One-to-Many: User has many UserMealLogs
    public function mealLogs()
    {
        return $this->hasMany(UserMealLog::class);
    }

    // One-to-Many: User has many custom FoodItems
    public function createdFoodItems()
    {
        return $this->hasMany(FoodItem::class, 'creator_user_id');
    }

    // One-to-Many: User has many UserWorkoutSchedules
    public function workoutSchedules()
    {
        return $this->hasMany(UserWorkoutSchedule::class);
    }

    // Many-to-Many: User has many Allergies
    public function allergies()
    {
        return $this->belongsToMany(Allergy::class, 'user_allergies')
                    ->withTimestamps();
    }
}
