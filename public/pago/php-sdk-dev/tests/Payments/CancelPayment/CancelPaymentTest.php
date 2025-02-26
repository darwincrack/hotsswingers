<?php

namespace PaylandsSDK\Tests\Payments\CancelPayment;

use PaylandsSDK\Requests\CancelPaymentRequest;
use PaylandsSDK\Requests\Payment;
use PaylandsSDK\Requests\PaymentOrderExtraData;
use PaylandsSDK\Responses\CancelPaymentResponse;
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

class CancelPaymentTest extends TestBase
{
    /**
 * @return void
 */
    public function test_cancelPaymentTest_ok()
    {
        $request = new CancelPaymentRequest("1f405ea3-9798-42a6-9e87-bd347ef67f55");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'POST',
                'payment/cancellation',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new CancelPaymentResponse(
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
                OrderStatus::CANCELLED(),
                [
                    new Transaction(
                        "A714DC03-70F6-4F71-AFB8-5E99B1868201",
                        "2017-01-12T09:12:58+0100",
                        "2017-01-12T09:12:58+0100",
                        Operative::DEFERRED(),
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
                        TransactionStatus::SUCCESS()
                    ),
                    new Transaction(
                        "9F47497E-CE8D-4772-A16D-464E5F410F68",
                        "2017-02-15T17:02:23+0000",
                        "2017-01-12T09:12:58+0100",
                        Operative::CANCELLATION(),
                        111,
                        "736288",
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
                        TransactionStatus::SUCCESS()
                    )
                ],
                ""
            ),
            new Client("818431F0-F23F-47EA-A854-BD01E8593E2E"),
            new PaymentOrderExtraData(new Payment(3))
        );

        $actual = $this->paylandsClient->cancelPayment($request);

        $this->assertEquals($expected, $actual);
    }
}
