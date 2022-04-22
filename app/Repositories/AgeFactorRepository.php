<?php

namespace App\Repositories;

use App\Models\AgeRating;

class AgeFactorRepository
{
    /**
     * @param int $age
     *
     * @return array
     */
    public function getForAge(int $age): array
    {
        /** @var \Illuminate\Database\Eloquent\Model $ageFactor */
        $ageFactor = AgeRating::where('age', $age)->firstOrFail();

        return $ageFactor->toArray();
    }
}
