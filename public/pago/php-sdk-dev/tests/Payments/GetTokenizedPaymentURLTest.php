<?php

namespace PaylandsSDK\Tests\Payments;

use PaylandsSDK\Requests\SendTokenizedPaymentRequest;
use PaylandsSDK\Tests\TestBase;

class GetTokenizedPaymentURLTest extends TestBase
{
    private $token = "ebc9b5ffa2efcf74197734a071192817e6f2a3fc15f49c4b1bdb6edc46b16e3ab4109498bff8e6ba00fb6d2bd1838afbea67095c4caaa2f46e4acf4d5851884c";

    /**
 * @return void
 */
    public function test_getTokenizedPaymentURLTest_ok()
    {
        $request = new SendTokenizedPaymentRequest($this->token);

        $this->httpClient->expects($this->once())
            ->method("getBaseUri")
            ->willReturn("");

        $expected = "payment/tokenized/" . $this->token;

        $actual = $this->paylandsClient->getTokenizedPaymentURL($request);

        $this->assertEquals($expected, $actual);
    }
}
