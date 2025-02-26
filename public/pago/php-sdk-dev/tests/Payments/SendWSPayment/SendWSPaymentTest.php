<?php

namespace PaylandsSDK\Tests\Payments\SendWSPayment;

use PaylandsSDK\Requests\Payment;
use PaylandsSDK\Requests\PaymentOrderExtraData;
use PaylandsSDK\Requests\SendWSPaymentRequest;
use PaylandsSDK\Responses\SendWSPaymentResponse;
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

class SendWSPaymentTest extends TestBase
{
    /**
 * @return void
 */
    public function test_sendWSPaymentTest_ok()
    {
        $request = new SendWSPaymentRequest(
            "62.43.214.55",
            "1f405ea3-9798-42a6-9e87-bd347ef67f55",
            "6887c5bf-df7d-4cfb-adb0-2edbf8f8325b"
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'POST',
                'payment/direct',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new SendWSPaymentResponse(
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
                "MIT",
                OrderStatus::SUCCESS(),
                [
                    new Transaction(
                        "A714DC03-70F6-4F71-AFB8-5E99B1868201",
                        "2017-01-12T09:12:58+0100",
                        "2017-01-12T09:12:58+0100",
                        Operative::AUTHORIZATION(),
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
                            "SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A.",
                            "",
                            null,
                            "main card"
                        ),
                        TransactionStatus::SUCCESS()
                    )
                ],
                "",
                "62.12.123.45",
                null,
                ""
            ),
            new Client("818431F0-F23F-47EA-A854-BD01E8593E2E"),
            new PaymentOrderExtraData(new Payment(3))
        );

        $actual = $this->paylandsClient->sendWSPayment($request);

        $this->assertEquals($expected, $actual);
    }
}
