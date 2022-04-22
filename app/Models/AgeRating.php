<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgeRating extends Model
{
    protected $table = 'age_rating';

    protected $fillable = [
        'age', 'rating_factor',
    ];

    protected $hidden = [];
}
