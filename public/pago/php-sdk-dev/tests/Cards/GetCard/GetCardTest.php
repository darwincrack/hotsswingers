<?php

namespace PaylandsSDK\Tests\Cards\GetCard;

use PaylandsSDK\Requests\GetCardRequest;
use PaylandsSDK\Responses\GetCardResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Card;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\Enums\CardType;
use PaylandsSDK\Utils\HttpResponse;

class GetCardTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getCardTest_ok()
    {
        $request = new GetCardRequest("C10721E7");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "GET",
                "payment-method/card/" . $request->getCardUuid()
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new GetCardResponse(
            "OK",
            200,
            "2017-01-12T09:12:58+0100",
            new Customer("user"),
            new Card(
                "CARD",
                "C089B1BF-A4FA-4B0F-A5FE-F21C5BFEFC27",
                CardType::C(),
                "c734c643edfdccf3555a157fbf7ccb08006fbb1f",
                "VISA",
                "840",
                "John doe",
                "454881",
                "0004",
                "12",
                "20",
                "JPMORGAN CHASE BANK, N.A.",
                "",
                null,
                "card12345"
            )
        );
        $actual = $this->paylandsClient->getCard($request);

        $this->assertEquals($expected, $actual);
    }
}
