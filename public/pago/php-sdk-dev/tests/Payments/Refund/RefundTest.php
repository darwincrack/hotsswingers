<?php

namespace PaylandsSDK\Tests\Payments\Refund;

use PaylandsSDK\Requests\Payment;
use PaylandsSDK\Requests\PaymentOrderExtraData;
use PaylandsSDK\Requests\RefundRequest;
use PaylandsSDK\Responses\RefundResponse;
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

class RefundTest extends TestBase
{
    /**
 * @return void
 */
    public function test_refundTest_ok()
    {
        $request = new RefundRequest("1f405ea3-9798-42a6-9e87-bd347ef67f55", 1200);
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'POST',
                'payment/refund',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new RefundResponse(
            "OK",
            200,
            "2017-01-12T09:12:58+0100",
            new Order(
                "114A527E-65C7-4720-99F6-DF635A4975E0",
                "2017-01-11T15:50:16+0100",
                "2017-01-11T15:50:16+0100",
                4200,
                "484",
                true,
                false,
                500,
                "MIT",
                OrderStatus::REFUNDED(),
                [
                    new Transaction(
                        "A714DC03-70F6-4F71-AFB8-5E99B1868201",
                        "2017-01-12T09:12:58+0100",
                        "2017-01-12T09:12:58+0100",
                        Operative::AUTHORIZATION(),
                        4200,
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
                            "SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A.",
                            "true",
                            null,
                            "main card"
                        ),
                        TransactionStatus::SUCCESS(),
                        null
                    ),
                    new Transaction(
                        "1538201e-9d65-478d-a8fd-853e97e7855b",
                        "2017-01-13T09:12:58+0100",
                        "2017-01-12T09:12:58+0100",
                        Operative::REFUND(),
                        500,
                        "012674",
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
                            "SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A.",
                            "true",
                            null,
                            "main card"
                        ),
                        TransactionStatus::SUCCESS(),
                        null
                    )
                ],
                "5d8938ddbe917764a08a58583758a031552dd5eda75f9778b5fd0b18e65894d997eb020c7e71f93471b1720e154d13e7390fd734434561f8a9299bd8f16ca970",
                null,
                null,
                ""
            ),
            new Client("818431F0-F23F-47EA-A854-BD01E8593E2E"),
            new PaymentOrderExtraData(new Payment(3))
        );

        $actual = $this->paylandsClient->refund($request);

        $this->assertEquals($expected, $actual);
    }
}
