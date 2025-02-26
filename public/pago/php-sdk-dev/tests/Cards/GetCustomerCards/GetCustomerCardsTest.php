<?php

namespace PaylandsSDK\Tests\Cards\GetCustomerCards;

use PaylandsSDK\Requests\GetCustomerCardsRequest;
use PaylandsSDK\Responses\GetCustomerCardsResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Card;
use PaylandsSDK\Types\Enums\CardStatus;
use PaylandsSDK\Types\Enums\CardType;
use PaylandsSDK\Utils\HttpResponse;

class GetCustomerCardsTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getCustomerCardsTest_ok()
    {
        $request = new GetCustomerCardsRequest(
            "C10721E7",
            CardStatus::ALL(),
            true
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "GET",
                "customer/" . $request->getCustomerExtId() . "/cards",
                ["query" => ["status" => $request->getStatus(), "unique" => $request->isUnique()]]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new GetCustomerCardsResponse(
            "OK",
            200,
            "2017-01-12T09:12:58+0100",
            [
                new Card(
                    "CARD",
                    "90F358C9-7D3F-4334-A60D-1717CC1FBF5B",
                    CardType::C(),
                    "ebc9b5ffa2efcf74197734a071192817e6f2a3fc15f49c4b1bdb6edc46b16e3ab4109498bff8e6ba00fb6d2bd1838afbea67095c4caaa2f46e4acf4d5851884c",
                    "VISA",
                    "724",
                    "Test user",
                    "454881",
                    "0004",
                    "12",
                    "21",
                    "SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A."
                ),
                new Card(
                    "CARD",
                    "0FDE261B-0E76-499D-A394-B6DCF6C03C56",
                    CardType::C(),
                    "ad49b5b1a2efcf74197734a071192817e6f2a3fc15f49c4b1bdb6edc46b16e3ab4109498bff8e6ba00fb6d2bd1838afbea67095c4caaa2f46e4acf4d58516cba",
                    "MASTERCARD",
                    "724",
                    "Test user",
                    "533821",
                    "0004",
                    "04",
                    "23",
                    "SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A."
                )
            ]
        );
        $actual = $this->paylandsClient->getCustomerCards($request);

        $this->assertEquals($expected, $actual);
    }
}
