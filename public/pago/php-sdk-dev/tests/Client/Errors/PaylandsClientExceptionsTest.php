<?php


namespace PaylandsSDK\Tests\Client\Errors;


use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Utils\HttpResponse;

class PaylandsClientExceptionsTest extends TestBase {

    /**
     * @expectedException \PaylandsSDK\Exceptions\PaylandsClientException
     * @expectedExceptionCode 500
     * @expectedExceptionMessage Internal Server Error
     */
    public function test_error500() {
        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->willReturn(new HttpResponse([], 500, $this->getExpectedResponse()));
        $this->paylandsClient->getApiKeyProfiles();
    }
}