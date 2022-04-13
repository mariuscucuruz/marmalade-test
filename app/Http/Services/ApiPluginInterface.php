<?php

namespace App\Http\Services;

interface ApiPluginInterface
{
    /**
     * @param array $payload
     *
     * @return array
     *
     * @throws \Exception
     */
    public function resolve(array $payload): array;
}
