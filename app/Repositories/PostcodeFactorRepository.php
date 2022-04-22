<?php

namespace App\Repositories;

use App\Models\PostcodeRating;

class PostcodeFactorRepository
{
    /**
     * @param string $postcode
     *
     * @return array
     */
    public function getForAreaCode(string $postcode): array
    {
        /** @var \Illuminate\Database\Eloquent\Model $areaFactor */
        $areaFactor = PostcodeRating::where('postcode_area', $postcode)->firstOrFail();

        return $areaFactor->toArray();
    }
}
