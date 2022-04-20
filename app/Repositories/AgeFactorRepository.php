<?php

namespace App\Repositories;

use App\Models\Age;

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
        $ageFactor = Age::where('age', $age)->firstOrFail();

        return $ageFactor->toArray();
    }
}
