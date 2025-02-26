<?php

namespace PaylandsSDK\Tests\Payments;

use PaylandsSDK\Requests\GetRedirectPaymentURLRequest;
use PaylandsSDK\Tests\TestBase;

class GetRedirectPaymentURLTest extends TestBase
{
    private $token = "ebc9b5ffa2efcf74197734a071192817e6f2a3fc15f49c4b1bdb6edc46b16e3ab4109498bff8e6ba00fb6d2bd1838afbea67095c4caaa2f46e4acf4d5851884c";

    /**
 * @return void
 */
    public function test_getRedirectPaymentURLTest_ok()
    {
        $request = new GetRedirectPaymentURLRequest($this->token);

        $this->httpClient->expects($this->once())
            ->method("getBaseUri")
            ->willReturn("");

        $expected = "payment/process/" . $this->token;

        $actual = $this->paylandsClient->getRedirectPaymentURL($request);

        $this->assertEquals($expected, $actual);
    }
}
