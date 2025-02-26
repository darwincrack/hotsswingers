<?php

namespace PaylandsSDK\Tests\Cards\SetCardDescription;

use PaylandsSDK\Requests\SetCardDescriptionRequest;
use PaylandsSDK\Responses\SetCardDescriptionResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Card;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\Enums\CardType;
use PaylandsSDK\Utils\HttpResponse;

class SetCardDescriptionTest extends TestBase
{
    /**
 * @return void
 */
    public function test_setCardDescriptionTest_ok()
    {
        $request = new SetCardDescriptionRequest(
            "C10721E7-1404-45DC-8762-351DD9945D1D",
            "Tarjeta principal"
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'PUT',
                $this->equalTo("payment-method/card/additional"),
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new SetCardDescriptionResponse(
            "OK",
            200,
            "2017-01-12T09:12:58+0100",
            new Customer("user", null),
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
                "Tarjeta principal"
            )
        );

        $actual = $this->paylandsClient->setCardDescription($request);

        $this->assertEquals($expected, $actual);
    }
}
