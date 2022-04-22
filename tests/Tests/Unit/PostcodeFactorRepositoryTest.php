<?php

use App\Models\PostcodeRating;
use App\Repositories\PostcodeFactorRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;

class PostcodeFactorRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_database_is_seeded()
    {
        $this->assertCount(3, PostcodeRating::all());
    }

    public function test_get_for_area_code_method_returns_expected()
    {
        $repository     = new PostcodeFactorRepository();
        $postcode       = 'LE10';
        $expectedFactor = 1.35;
        $postodeFactor  = $repository->getForAreaCode($postcode);

        $this->assertEquals($expectedFactor, $postodeFactor['rating_factor']);
    }
}
