<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbiCodeRating extends Model
{
    protected $table = 'abi_code_rating';

    protected $fillable = [
        'abi_code', 'rating_factor',
    ];

    protected $hidden = [];
}
