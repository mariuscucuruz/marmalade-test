<?php

namespace Tests\Acceptance;

use Illuminate\Http\Response;
use TestCase;

class AcceptanceTest extends TestCase
{
    protected string $routeUrl = 'marmalade/';

    /**
     * @test
     *
     * The endpoint accepts GET requests and returns framework version.
     */
    public function api_endpoint_responds_to_get_requests_test()
    {
        // given
        $expectedResponse = $this->app->version();

        // when
        $requestResponse = $this->call('GET', $this->routeUrl);

        // then
        self::assertEquals(Response::HTTP_OK, $requestResponse->status());
        self::assertEquals($expectedResponse, $requestResponse->content());
    }

    /**
     * @test
     *
     * The endpoint rejects PUT requests.
     */
    public function api_endpoint_rejects_put_requests_test()
    {
        // given

        // when
        $requestResponse = $this->call('PUT', $this->routeUrl, []);

        // then
        self::assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $requestResponse->status());
    }

    /**
     * @test
     *
     * The endpoint accepts POST requests and returns framework version (no validation yet).
     *
     * @throws \JsonException
     */
    public function api_endpoint_responds_to_post_requests_test()
    {
        // given
        $requestPayload = $this->makeValidPostRequestPayload();

        // when
        $requestResponse = $this->call('POST', $this->routeUrl, $requestPayload);

        // then
        $expected = json_encode([
            'abi_code' => $this->app->version(),
        ], JSON_THROW_ON_ERROR);

        self::assertEquals(Response::HTTP_OK, $requestResponse->status());
        self::assertEquals($expected, $requestResponse->getContent());
    }

    /**
     * @test
     * The endpoint should accept a JSON payload containing the following:
     * {
     *   "age": 20,
     *   "postcode": "PE3 8AF",
     *   "regNo": "PJ63 LXR"
     * }
     * make a call to API to look up the vehicle registration number and return an ABI code.
     * @throws \JsonException
     */
    public function api_endpoint_responds_to_post_requests_test()
    {
        // given
        $requestPayload = [
            'age'       => 20,
            'postcode' => "PE3 8AF",
            'regNo'    => "PJ63 LXR"
        ];

        // when
        $requestResponse = $this->call('POST', $this->routeUrl, $requestPayload);

        // then
        $expected = json_encode([
            'abi_code' => $this->app->version(),
        ], JSON_THROW_ON_ERROR);

        self::assertEquals(Response::HTTP_OK, $requestResponse->status());
        self::assertEquals($expected, $requestResponse->getContent());
    }

    /**
     * @param int    $age
     * @param string $postcode
     * @param string $regNo
     *
     * @return array
     */
    private function makeValidPostRequestPayload(int $age = 20, string $postcode = 'PE3 8AF', string $regNo = 'PJ63 LXR'): array
    {
        return [
            'age'      => $age,
            'postcode' => $postcode,
            'regNo'    => $regNo
        ];
    }
}
