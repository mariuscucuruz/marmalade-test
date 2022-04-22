<?php

use App\Models\AbiCodeRating;
use App\Repositories\AbiCodeFactorRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AbiCodeFactorRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_database_is_seeded()
    {
        $this->assertCount(3, AbiCodeRating::all());
    }

    public function test_get_for_abi_code_returns_expected()
    {
        $repository     = new AbiCodeFactorRepository();
        $abiCode        = '52123803';
        $expectedFactor = 1.20;
        $abiCodeFactor = $repository->getForAbiCode($abiCode);

        $this->assertEquals($expectedFactor, $abiCodeFactor['rating_factor']);
    }
}
