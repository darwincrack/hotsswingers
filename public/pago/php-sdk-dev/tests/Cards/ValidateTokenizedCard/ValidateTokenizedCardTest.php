<?php

namespace PaylandsSDK\Tests\Cards\ValidateTokenizedCard;

use PaylandsSDK\Requests\ValidateTokenizedCardRequest;
use PaylandsSDK\Responses\ValidateTokenizedCardResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Card;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\Enums\CardType;
use PaylandsSDK\Utils\HttpResponse;

class ValidateTokenizedCardTest extends TestBase
{
    /**
 * @return void
 */
    public function test_validateTokenizedCardTest_ok()
    {
        $request = new ValidateTokenizedCardRequest(
            "source uuid",
            "12345678A",
            "Service UUID",
            "123"
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "GET",
                "payment-method/card/validate",
                ["json" => $request->parseRequest()]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new ValidateTokenizedCardResponse(
            "OK",
            200,
            "2017-01-12T09:12:58+0100",
            new Customer("12345678A"),
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
                "SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A.",
                ""
            )
        );
        $actual = $this->paylandsClient->validateTokenizedCard($request);
        $this->assertEquals($expected, $actual);
    }
}
