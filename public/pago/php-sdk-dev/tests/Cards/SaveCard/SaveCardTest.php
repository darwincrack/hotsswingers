<?php

namespace PaylandsSDK\Tests\Cards\SaveCard;

use PaylandsSDK\Requests\SaveCardRequest;
use PaylandsSDK\Responses\SaveCardResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Card;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\Enums\CardType;
use PaylandsSDK\Utils\HttpResponse;

class SaveCardTest extends TestBase
{
    /**
 * @return void
 */
    public function test_saveCardTest_ok()
    {
        $request = new SaveCardRequest(
            "12345678A",
            "John Doe",
            "4548 8120 4940 0004",
            "20",
            "12",
            "123",
            true,
            "das"
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "payment-method/card",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new SaveCardResponse(
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
                "2017-01-12 09:12:58",
                "card12345"
            )
        );
        $actual = $this->paylandsClient->saveCard($request);
        $this->assertEquals($expected, $actual);
    }
}
