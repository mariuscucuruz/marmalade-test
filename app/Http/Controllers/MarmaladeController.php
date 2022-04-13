<?php

namespace App\Http\Controllers;

use App\Exceptions\AgeInvalidException;
use App\Exceptions\PostcodeInvalidException;
use App\Exceptions\RegInvalidException;
use App\Http\Services\ApiPluginInterface;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarmaladeController extends Controller
{
    /**
     * @var \App\Http\Services\ApiPluginInterface
     */
    private ApiPluginInterface $service;

    /**
     * @param \App\Http\Services\ApiPluginInterface $regService
     */
    public function __construct(ApiPluginInterface $regService)
    {
        $this->service = $regService;
    }

    /**
     * @param \Laravel\Lumen\Http\Request $request
     *
     * @return string
     */
    public function resolveRegistrationFromRequest(Request $request)
    {
        $requestPayload = $request->only([
            'age',
            'postcode',
            'registration'
        ]);

        $payload = $this->validatePayload($requestPayload);

        $response = $this->service->resolve($payload);

        return $this->formatApiResponse($response);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    protected function validatePayload(array $array = []): array
    {
        if (1 > count($array)) {
            throw new \InvalidArgumentException();
        }

        if (!$age = $this->parseInteger($array['age'])) {
            throw new AgeInvalidException();
        }

        if (!$postcode = $this->parseString($array['postcode'])) {
            throw new PostcodeInvalidException();
        }

        if (!$registration = $this->parseString($array['registration'])) {
            throw new RegInvalidException();
        }

        return [
            $age,
            $postcode,
            $registration
        ];
    }

    /**
     * Rudimentary string validation.
     *
     * @param $value
     *
     * @return int
     */
    protected function parseInteger($value = null): int
    {
        if (!isset($value) || !is_int($value)) {
            throw new AgeInvalidException();
        }

        return (int) $value;
    }

    /**
     * Rudimentary string validation.
     *
     * @param $value
     *
     * @return string
     */
    protected function parseString($value = null): string
    {
        if (!isset($value) || !is_string($value)) {
            throw new PostcodeInvalidException();
        }

        return str($value);
    }

    /**
     * Consistent formatter for all responses.
     *
     * @param array $response
     * @param int   $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function formatApiResponse(array $response = [], int $status = Response::HTTP_OK): JsonResponse
    {
        if (!isset($response['abi_code'])) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return response()->json($response, $response);
    }
}
