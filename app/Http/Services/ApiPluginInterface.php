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
    public function resolvePremium(array $payload): array;
}
