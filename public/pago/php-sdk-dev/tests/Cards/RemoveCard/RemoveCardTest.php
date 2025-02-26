<?php

namespace PaylandsSDK\Tests\Cards\RemoveCard;

use PaylandsSDK\Requests\RemoveCardRequest;
use PaylandsSDK\Responses\RemoveCardResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Utils\HttpResponse;

class RemoveCardTest extends TestBase
{
    /**
 * @return void
 */
    public function test_removeCardTest_ok()
    {
        $request = new RemoveCardRequest(
            "C10721E7",
            "user1234"
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "DELETE",
                "payment-method/card",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new RemoveCardResponse("OK", 200, "2017-01-12T09:12:58+0100");

        $actual = $this->paylandsClient->removeCard($request);

        $this->assertEquals($expected, $actual);
    }
}
