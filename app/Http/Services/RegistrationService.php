<?php

namespace App\Http\Services;

use Faker\Generator;

class RegistrationService implements ApiPluginInterface
{
    /**
     * @var \Faker\Generator
     */
    private Generator $faker;

    /**
     * @param \Faker\Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->faker = $generator;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function resolve(array $payload): array
    {
        return [
            'abi_code' => $this->faker->uuid()
        ];
    }
}
