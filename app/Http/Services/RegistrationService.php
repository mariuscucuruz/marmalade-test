<?php

namespace App\Http\Services;

use App\Exceptions\ApiResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class RegistrationService implements ApiPluginInterface
{
    /**
     * @var string
     */
    public const OTHER_API_URL = 'https://other.api/';

    /**
     * @param array $payload
     *
     * @return array
     */
    public function resolve(array $payload): array
    {
        $this->makeApiRequest($payload);
    }

    /**
     * @param array $array
     *
     * @return \Illuminate\Http\Response
     */
    protected function makeApiRequest(array $array = []): Response
    {
        try {
            $request  = Http::acceptJson()->post(self::OTHER_API_URL, $array);
            $response = $request->json();

            return $response['abi_code'];
        }
        catch (\Exception $exception) {
            throw new ApiResponseException($exception->getMessage());
        }
    }
}
