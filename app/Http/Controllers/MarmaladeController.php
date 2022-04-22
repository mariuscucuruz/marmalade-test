<?php

namespace App\Http\Controllers;

use App\Exceptions\AgeInvalidException;
use App\Exceptions\ApiResponseException;
use App\Exceptions\PostcodeInvalidException;
use App\Exceptions\RegInvalidException;
use App\Http\Services\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarmaladeController extends Controller
{
    /**
     * @var \App\Http\Services\RegistrationService
     */
    private RegistrationService $service;

    /**
     * @param \App\Http\Services\RegistrationService $regService
     */
    public function __construct(RegistrationService $regService)
    {
        $this->service = $regService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resolvePremiumFromRequest(Request $request): JsonResponse
    {
        $requestPayload = $request->only([
            'age',
            'postcode',
            'registration'
        ]);
        #dd($request->all(), $requestPayload);

        $payload = $this->validatePayload($requestPayload);

        try {
            $payload['abiCode'] = $this->service->getAbiCodeFromRegNo($requestPayload['registration']);

            // add up all premium values together to get a total
            $totalPremium = array_sum($this->service->resolvePremiums($payload));
        }
        catch (\Exception $exception) {
            throw new ApiResponseException($exception->getMessage());
        }

        return $this->formatApiResponse($totalPremium);
    }

    /**
     * Consistent, unified formatter for all responses.
     *
     * @param array|mixed $response
     * @param int         $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function formatApiResponse($response, int $status = Response::HTTP_OK): JsonResponse
    {
        if (!$response) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        $formatted = [
            'total_premium' => $response
        ];

        return response()->json($formatted, $status);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    protected function validatePayload(array $array = []): array
    {
        if (1 > count($array)) {
            throw new \InvalidArgumentException(count($array));
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
            'age'          => $age,
            'postcode'     => $postcode,
            'registration' => $registration
        ];
    }

    /**
     * Rudimentary string validation.
     *
     * @param null $value
     *
     * @return int|null
     */
    protected function parseInteger($value = null): ?int
    {
        if (!isset($value) || !is_int($value)) {
            return null;
        }

        return (int) $value;
    }

    /**
     * Rudimentary string validation.
     *
     * @param null $value
     *
     * @return string|null
     */
    protected function parseString($value = null): ?string
    {
        if (!isset($value) || !is_string($value)) {
            return null;
        }

        return str($value);
    }
}
