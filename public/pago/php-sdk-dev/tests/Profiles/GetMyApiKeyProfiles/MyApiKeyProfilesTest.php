<?php

namespace PaylandsSDK\Tests\Profiles\GetMyApiKeyProfiles;

use PaylandsSDK\Exceptions\PaylandsClientException;
use PaylandsSDK\Responses\GetMyApiKeyProfilesResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\ErrorResponse;
use PaylandsSDK\Utils\HttpResponse;

class MyApiKeyProfilesTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getMyApiKeyProfiles_givenNoParameters_shouldReturn()
    {
        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'api-key/me')
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new GetMyApiKeyProfilesResponse(
            "OK",
            200,
            "2019-05-30T12:55:48+0200",
            [
                "payment",
                "readonly",
                "tokenize",
                "batch",
                "keyentry"
            ],
            true
        );

        $actual = $this->paylandsClient->getMyApiKeyProfiles();

        $this->assertEquals($expected, $actual);
    }

    /**
 * @return void
 */
    public function test_getMyApiKeyProfiles_givenUnexpectedError_expectException()
    {
        $expectedException = new PaylandsClientException(new ErrorResponse('Bad request', 400, 'Some parameter is missing.'));
        $this->expectExceptionObject($expectedException);

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'api-key/me')
            ->willReturn(new HttpResponse([], 400, $this->getExpectedResponse()));

        $this->paylandsClient->getMyApiKeyProfiles();
    }
}
