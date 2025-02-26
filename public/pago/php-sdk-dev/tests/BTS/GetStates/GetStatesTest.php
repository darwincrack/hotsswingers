<?php


namespace PaylandsSDK\Tests\BTS\GetStates;

use PaylandsSDK\Requests\GetStatesRequest;
use PaylandsSDK\Responses\GetStatesResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\State;
use PaylandsSDK\Utils\HttpResponse;

class GetStatesTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getStatesTest_ok()
    {
        $request = new GetStatesRequest("service uuid", "MXP");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "bts/states",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new GetStatesResponse(
            "OK",
            200,
            "2020-02-24T10:08:02+0100",
            [
                new State("NOT SET", "999", "MEX"),
                new State("AGUASCALIENTES", "AGS", "MEX"),
            ]
        );
        $actual = $this->paylandsClient->getStates($request);
        $this->assertEquals($expected, $actual);
    }
}
