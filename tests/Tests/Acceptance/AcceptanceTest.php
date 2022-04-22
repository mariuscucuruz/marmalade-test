<?php

namespace Tests\Acceptance;

use App\Exceptions\AgeInvalidException;
use App\Exceptions\PostcodeInvalidException;
use App\Exceptions\RegInvalidException;
use Illuminate\Http\Response;
use InvalidArgumentException;
use TestCase;

class AcceptanceTest extends TestCase
{
    protected string $routeUrl = '/marmalade/';

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
        $requestPayload = [];

        // when
        $requestResponse = $this->post($this->routeUrl, $requestPayload, $this->makeJsonHeaders());

        // then
        $requestResponse
            ->seeJsonContains([
                'exception' => \InvalidArgumentException::class
            ])
            ->assertResponseStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
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
     */
    public function api_endpoint_expects_age_as_intiger_in_post_requests_test()
    {
        // given
        $requestPayload = $this->makePostRequestPayload(20.1, 'PE3 8AF', 'GN66PJO');

        // when
        $requestResponse = $this->json('POST', $this->routeUrl, $requestPayload, $this->makeJsonHeaders());

        // then
        $requestResponse
            ->seeJsonContains([
                'exception' => AgeInvalidException::class
            ])
            ->assertResponseStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @test
     */
    public function api_endpoint_expects_postcode_as_string_in_post_requests_test()
    {
        // given
        $requestPayload = $this->makePostRequestPayload(20, 666, 'GN66PJO');

        // when
        $requestResponse = $this->json('POST', $this->routeUrl, $requestPayload, $this->makeJsonHeaders());

        // then
        $requestResponse
            ->seeJsonContains([
                'exception' => PostcodeInvalidException::class
            ])
            ->assertResponseStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @test
     */
    public function api_endpoint_expects_reg_as_string_in_post_requests_test()
    {
        // given
        $requestPayload = $this->makePostRequestPayload(20, 'PE3 8AF', 9999);

        // when
        $requestResponse = $this->json('POST', $this->routeUrl, $requestPayload, $this->makeJsonHeaders());

        // then
        $requestResponse
            ->seeJsonContains([
                'exception' => RegInvalidException::class
            ])
            ->assertResponseStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param int    $age
     * @param string $postcode
     * @param string $regNo
     *
     * @return array
     */
    private function makePostRequestPayload($age = 20, $postcode = 'PE3 8AF', $regNo = 'PJ63 LXR'): array
    {
        return [
            'age'           => $age,
            'postcode'      => $postcode,
            'registration'  => $regNo
        ];
    }

    /**
     * @return string[]
     */
    private function makeJsonHeaders(): array
    {
        return [
            'Content-Type'  =>'application/json',
            'accept'        => 'application/json',
        ];
    }
}
