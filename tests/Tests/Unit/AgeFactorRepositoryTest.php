<?php

use App\Models\AgeRating;
use App\Repositories\AgeFactorRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AgeFactorRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_database_is_seeded()
    {
        $this->assertCount(9, AgeRating::all());
    }

    public function test_get_for_age_method_returns_expected()
    {
        $repository     = new AgeFactorRepository();
        $age            = 21;
        $expectedFactor = 1.10;
        $ageFactor      = $repository->getForAge($age);

        $this->assertEquals($expectedFactor, $ageFactor['rating_factor']);
    }
}
