<?php

namespace App\Http\Services;

use App\Exceptions\ApiResponseException;
use App\Repositories\AbiCodeFactorRepository;
use App\Repositories\AgeFactorRepository;
use App\Repositories\PostcodeFactorRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class RegistrationService implements ApiPluginInterface
{
    public const BASE_PREMIUM_GBP = 500;
    public const DEFAULT_FACTOR_IF_NOT_FOUND = 1;

    /**
     * @var string
     */
    public const OTHER_API_URL = 'https://other.api/';

    /**
     * @var \App\Repositories\AbiCodeFactorRepository
     */
    private AbiCodeFactorRepository $abiCodeFactorRepository;

    /**
     * @var \App\Repositories\PostcodeFactorRepository
     */
    private PostcodeFactorRepository $postcodeFactorRepository;

    /**
     * @var \App\Repositories\AgeFactorRepository
     */
    private AgeFactorRepository $ageFactorRepository;

    /**
     * @param \App\Repositories\AgeFactorRepository      $ageFactorRepository
     * @param \App\Repositories\AbiCodeFactorRepository  $abiCodeFactorRepository
     * @param \App\Repositories\PostcodeFactorRepository $postcodeFactorRepository
     */
    public function __construct(
        AgeFactorRepository $ageFactorRepository,
        AbiCodeFactorRepository $abiCodeFactorRepository,
        PostcodeFactorRepository $postcodeFactorRepository
    ) {
        $this->ageFactorRepository      = $ageFactorRepository;
        $this->abiCodeFactorRepository  = $abiCodeFactorRepository;
        $this->postcodeFactorRepository = $postcodeFactorRepository;
    }
    /**
     * @param array $payload
     *
     * @return array
     */
    public function resolvePremium(array $payload): array
    {
        try {
            // attempt to get the rating factors from 3rd party API
            $factors = $this->getFactorsFromApi($payload);
        }
        catch (\Exception $exception) {
            // get rating factors from local storage
            $factors = $this->getFactorsFromLocal($payload);
        }

        return array_map(static function (float $factor) {
            if ($factor > 0) {
                return $factor * self::BASE_PREMIUM_GBP;
            }
        }, $factors);
    }

    /**
     * @param array $payload
     *
     * @return float[]
     */
    protected function getFactorsFromLocal(array $payload): array
    {
        return [
            $this->getAgeFactor($payload[0]),
            $this->getAbiCodeFactor($payload[1]),
            $this->getPostcodeFactor($payload[2]),
        ];
    }

    /**
     * @param int $age
     *
     * @return float
     */
    protected function getAgeFactor(int $age): float
    {
        $ageFactor = $this->ageFactorRepository->getForAge($age);

        return $ageFactor['rating_factor'] ?? self::DEFAULT_FACTOR_IF_NOT_FOUND;
    }

    /**
     * @param string $abiCode
     *
     * @return float
     */
    protected function getAbiCodeFactor(string $abiCode): float
    {
        $abiFactor = $this->abiCodeFactorRepository->getForAbiCode($abiCode);

        return $abiFactor['rating_factor'] ?? self::DEFAULT_FACTOR_IF_NOT_FOUND;
    }

    /**
     * @param string $areaCode
     *
     * @return float
     */
    protected function getPostcodeFactor(string $areaCode): float
    {
        $postcodeFactor = $this->postcodeFactorRepository->getForAreaCode($areaCode);

        return $postcodeFactor['rating_factor'] ?? self::DEFAULT_FACTOR_IF_NOT_FOUND;
    }

    /**
     * @param array $array
     *
     * @return array
     *
     * @throws \HttpException
     */
    protected function getFactorsFromApi(array $array = []): array
    {
        $request  = Http::acceptJson()->post(self::OTHER_API_URL, $array);
        $response = $request->json();

        return $response;
    }
}
