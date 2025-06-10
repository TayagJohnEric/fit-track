<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessFact extends Model
{
    protected $table = 'fitness_facts';
    
    protected $fillable = [
        'fact_text',
        'category',
    ];
}
