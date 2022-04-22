<?php

namespace App\Repositories;

use App\Models\AbiCodeRating;

class AbiCodeFactorRepository
{
    /**
     * @param string $abi_code
     *
     * @return array
     */
    public function getForAbiCode(string $abi_code): array
    {
        /** @var \Illuminate\Database\Eloquent\Model $abiFactor */
        $abiFactor = AbiCodeRating::where('abi_code', $abi_code)->firstOrFail();

        return $abiFactor->toArray();
    }
}
