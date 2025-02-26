<?php

namespace PaylandsSDK\Tests\Profiles\GetApiKeyProfiles;

use PaylandsSDK\Responses\GetApiKeyProfilesResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Utils\HttpResponse;

class GetApiKeyProfilesTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getApiKeyProfiles_givenNoParameters_shouldReturn()
    {
        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'api-key/profiles')
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new GetApiKeyProfilesResponse(
            "OK",
            200,
            "2019-05-30T12:55:48+0200",
            [
                "payment",
                "refund",
                "readonly",
                "card",
                "tokenize",
                "moto",
                "batch_authorization",
                "batch_refund",
                "keyentry"
            ]
        );

        $actual = $this->paylandsClient->getApiKeyProfiles();

        $this->assertEquals($expected, $actual);
    }
}
