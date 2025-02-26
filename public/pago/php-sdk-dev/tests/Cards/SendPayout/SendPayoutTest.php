<?php

namespace PaylandsSDK\Tests\Cards\SendPayout;

use PaylandsSDK\Requests\Payment;
use PaylandsSDK\Requests\PaymentOrderExtraData;
use PaylandsSDK\Requests\SendPayoutRequest;
use PaylandsSDK\Responses\SendPayoutResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Card;
use PaylandsSDK\Types\Client;
use PaylandsSDK\Types\Enums\CardType;
use PaylandsSDK\Types\Enums\Operative;
use PaylandsSDK\Types\Enums\OrderStatus;
use PaylandsSDK\Types\Enums\TransactionStatus;
use PaylandsSDK\Types\Order;
use PaylandsSDK\Types\Transaction;
use PaylandsSDK\Utils\HttpResponse;

class SendPayoutTest extends TestBase
{
    /**
 * @return void
 */
    public function test_sendPayoutTest_ok()
    {
        $request = new SendPayoutRequest("20d9f4f1-be10-4f91-9f91-ffecb1319a24", "");

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'POST',
                'payment/payout',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new SendPayoutResponse(
            "OK",
            200,
            "2017-01-12T09:12:58+0100",
            new Order(
                "114A527E-65C7-4720-99F6-DF635A4975E0",
                "2017-01-11T15:50:16+0100",
                "2017-01-11T15:50:16+0100",
                111,
                "484",
                true,
                false,
                0,
                "REDSYS",
                OrderStatus::PAID(),
                [
                    new Transaction(
                        "A714DC03-70F6-4F71-AFB8-5E99B1868201",
                        "2017-01-12T09:12:58+0100",
                        "2017-01-12T09:12:58+0100",
                        Operative::PAYOUT(),
                        111,
                        "014639",
                        "NONE",
                        new Card(
                            "CARD",
                            "C089B1BF-A4FA-4B0F-A5FE-F21C5BFEFC27",
                            CardType::C(),
                            "c734c643edfdccf3555a157fbf7ccb08006fbb1f",
                            "VISA",
                            "ES",
                            "pepe",
                            "454881",
                            "0004",
                            "12",
                            "20",
                            "SERVIRED, SOCIEDAD ESPANOLA DE MEDIO",
                            "true"
                        ),
                        TransactionStatus::SUCCESS(),
                        null
                    )
                ],
                "",
                null,
                null,
                ""
            ),
            new Client("818431F0-F23F-47EA-A854-BD01E8593E2E"),
            new PaymentOrderExtraData(new Payment(3))
        );

        $actual = $this->paylandsClient->sendPayout($request);

        $this->assertEquals($expected, $actual);
    }
}
