<?php


namespace PaylandsSDK\Tests\BTS\GetPaymentTypeByAgent;

use PaylandsSDK\Requests\GetPaymentTypeByAgentRequest;
use PaylandsSDK\Responses\GetPaymentTypeByAgentResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Enums\PaymentTypeCd;
use PaylandsSDK\Types\PaymentType;
use PaylandsSDK\Utils\HttpResponse;

class GetPaymentTypeByAgentTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getPaymentTypeByAgentTest_ok()
    {
        $request = new GetPaymentTypeByAgentRequest("service_uuid");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "bts/payment-agents-payment-types",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new GetPaymentTypeByAgentResponse(
            "OK",
            200,
            "2020-02-21T14:55:16+0100",
            [
                new PaymentType("001", PaymentTypeCd::ACC(), "BRA", "BRL"),
                new PaymentType("003", PaymentTypeCd::ACC(), "BRA", "BRL"),
            ]
        );
        $actual = $this->paylandsClient->getPaymentTypeByAgent($request);
        $this->assertEquals($expected, $actual);
    }
}
