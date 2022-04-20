<?php

namespace App\Repositories;

use App\Models\Postcode;

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
        $areaFactor = Postcode::where('postcode_area', $postcode)->firstOrFail();

        return $areaFactor->toArray();
    }
}
