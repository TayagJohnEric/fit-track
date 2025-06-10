<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightHistory extends Model
{
    protected $table = 'weight_history';
    
    protected $fillable = [
        'user_id',
        'log_date',
        'weight_kg',
    ];

    protected $casts = [
        'log_date' => 'date',
        'weight_kg' => 'decimal:1',
    ];

    // One-to-Many (Inverse): WeightHistory belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
