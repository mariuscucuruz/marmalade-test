<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostcodeRating extends Model
{
    protected $table = 'postcode_rating';

    protected $fillable = [
        'postcode_area', 'rating_factor',
    ];

    protected $hidden = [];
}
