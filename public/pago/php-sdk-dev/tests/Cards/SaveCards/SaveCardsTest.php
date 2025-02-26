<?php

namespace PaylandsSDK\Tests\Cards\SaveCards;

use PaylandsSDK\Requests\CustomerCardRequest;
use PaylandsSDK\Requests\SaveCardsRequest;
use PaylandsSDK\Responses\SaveCardsResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Card;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\CustomerCard;
use PaylandsSDK\Types\Enums\CardType;
use PaylandsSDK\Utils\HttpResponse;

class SaveCardsTest extends TestBase
{
    /**
 * @return void
 */
    public function test_saveCardsTest_ok()
    {
        $card1 = new CustomerCardRequest(
            "user",
            "John Doe",
            "4111111111",
            "19",
            "12",
            "123",
            "http://www.example.com",
            "card12345"
        );
        $request = new SaveCardsRequest([$card1]);

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "payment-method/card/batch",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new SaveCardsResponse(
            "OK",
            200,
            "2017-01-12T09:12:58+0100",
            [
                new CustomerCard(
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
                        "2017-01-12 09:12:58",
                        "card12345"
                    )
                )
            ]
        );

        $actual = $this->paylandsClient->saveCards($request);
        $this->assertEquals($expected, $actual);
    }
}
