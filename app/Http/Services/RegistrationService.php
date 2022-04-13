<?php

namespace App\Http\Services;

use Faker\Factory;

class RegistrationService implements ApiPluginInterface
{
    private \Faker\Generator $faker;

    /**
     *
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function resolve(array $payload): array
    {
        return [
            'abi_code' => $this->faker->uuid
        ];
    }
}
