<?php


namespace PaylandsSDK\Tests\BTS\GetAccountTypeByAgent;

use PaylandsSDK\Requests\GetAccountTypeByAgentRequest;
use PaylandsSDK\Responses\GetAccountTypeByAgentResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Utils\HttpResponse;

class GetAccountTypeByAgentTest extends TestBase
{
    /**
     * @return void
     */
    public function test_getAccountTypeByAgentTest_ok()
    {
        $request = new GetAccountTypeByAgentRequest(
            "service uuid",
            "EK6",
            "MEX",
            "MXP"
        );
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "bts/account-types-payment-agents",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new GetAccountTypeByAgentResponse(
            "OK",
            200,
            "2020-02-24T10:01:24+0100",
            ["NOT"]
        );
        $actual = $this->paylandsClient->getAccountTypeByAgent($request);
        $this->assertEquals($expected, $actual);
    }
}
