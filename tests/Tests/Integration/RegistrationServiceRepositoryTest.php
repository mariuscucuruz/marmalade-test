<?php

namespace Tests\Integration;

use App\Http\Services\RegistrationService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class RegistrationServiceRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_service_resolves_reg_no_to_default_hardcoded_value()
    {
        // given
        $hardcodedAbiCode = '52123803';

        /** @var RegistrationService $service */
        $service = app(RegistrationService::class);

        // when
        $abiCode = $service->getAbiCodeFromRegNo('whatever value');

        // then
        $this->assertEquals($hardcodedAbiCode, $abiCode);
    }
}
