<?php


namespace PaylandsSDK\Tests\BTS\GetPaymentAgents;

use PaylandsSDK\Requests\GetPaymentAgentsRequest;
use PaylandsSDK\Responses\GetPaymentAgentsResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\PaymentAgent;
use PaylandsSDK\Utils\HttpResponse;

class GetPaymentAgentsTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getPaymentAgentsTest_ok()
    {
        $request = new GetPaymentAgentsRequest("service uuid");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "bts/payment-agents",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new GetPaymentAgentsResponse(
            "OK",
            200,
            "2020-02-24T09:23:11+0100",
            [
                new PaymentAgent("001", "AGNT 1"),
                new PaymentAgent("003", "A3"),
                new PaymentAgent("VWB", "NAME VWB"),
            ]
        );
        $actual = $this->paylandsClient->getPaymentAgents($request);
        $this->assertEquals($expected, $actual);
    }
}
