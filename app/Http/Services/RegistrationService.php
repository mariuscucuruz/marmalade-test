<?php

namespace App\Http\Services;

use App\Exceptions\ApiResponseException;
use App\Repositories\AbiCodeFactorRepository;
use App\Repositories\AgeFactorRepository;
use App\Repositories\PostcodeFactorRepository;
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
    public function resolvePremiums(array $payload): array
    {
        $factors = $this->getFactors($payload);

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
    protected function getFactors(array $payload): array
    {
        return [
            $this->getAgeFactor($payload['age']),
            $this->getAbiCodeFactor($payload['abiCode']),
            $this->getPostcodeFactor($payload['postcode']),
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
    protected function getPostcodeFactor(string $postcode): float
    {
        $postCodeParts  = explode(" ", $postcode);
        $areaCode       = $postCodeParts[0];
        $postcodeFactor = $this->postcodeFactorRepository->getForAreaCode($areaCode);

        return $postcodeFactor['rating_factor'] ?? self::DEFAULT_FACTOR_IF_NOT_FOUND;
    }

    /**
     * @param string $registration
     *
     * @return string
     */
    public function getAbiCodeFromRegNo(string $registration): string
    {
        $payload = [
            'regNo' => $registration,
        ];

        try {
            $request = Http::acceptJson()->post(self::OTHER_API_URL, $payload);

            /** @var array $response */
            $response = $request->json();
        } catch (\Exception $exception) {
            // hardcode default AbiCode to value from AbiCodeRatingTableSeeder
            $response['abiCode'] = '52123803';
        }

        if (!isset($response['abiCode'])) {
            throw new ApiResponseException();
        }

        return $response['abiCode'];
    }
}
