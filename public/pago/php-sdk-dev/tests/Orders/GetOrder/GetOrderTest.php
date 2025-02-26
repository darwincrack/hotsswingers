<?php

namespace PaylandsSDK\Tests\Orders\GetOrder;

use PaylandsSDK\Requests\GetOrderRequest;
use PaylandsSDK\Requests\Payment;
use PaylandsSDK\Requests\PaymentOrderExtraData;
use PaylandsSDK\Responses\GetOrderResponse;
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

class GetOrderTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getOrderTest_ok()
    {
        $request = new GetOrderRequest("6048FBA6-A280-4660-9746-9E5AD17EA6BA");

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "GET",
                "order/" . $request->getOrderUuid()
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new GetOrderResponse(
            "OK",
            200,
            "2020-03-11 12:00:00",
            new Order(
                "6048FBA6-A280-4660-9746-9E5AD17EA6BA",
                "2019-05-02T11:46:31+0200",
                "2019-05-02T11:46:31+0200",
                1200,
                "978",
                true,
                false,
                200,
                "REDSYS",
                OrderStatus::PARTIALLY_REFUNDED(),
                [
                    new Transaction(
                        "2452A605-32CD-4FCF-B1E8-C732A8C98F9F",
                        "2016-06-01T08:30:01.620Z",
                        "2019-05-02T08:30:01+0200",
                        Operative::AUTHORIZATION(),
                        1200,
                        "7654",
                        "NONE",
                        new Card(
                            "CARD",
                            "3351260A-11AC-454EA-C732A8C98F9F",
                            CardType::C(),
                            "c734c643edfdccf3555a157fbf7ccb08006fbb1f",
                            "VISA",
                            "ES",
                            "TITULAR DE PRUEBAS",
                            "405282",
                            "1011",
                            "09",
                            "16",
                            "SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A.",
                            ""
                        ),
                        TransactionStatus::SUCCESS()
                    ),
                    new Transaction(
                        "21C28F2C-BF9C-424A-91C5-7D19A48E50DB",
                        "2016-06-02T06:41:01.620Z",
                        "2016-06-02T06:41:01+0200",
                        Operative::CONFIRMATION(),
                        1200,
                        "7723",
                        "NONE",
                        new Card(
                            "CARD",
                            "ABAB111A-CCCC-AAE3-C222A81EC8F9F",
                            CardType::C(),
                            "c734c643edfdccf3555a157fbf7ccb08006fbb1f",
                            "VISA",
                            "ES",
                            "TITULAR DE PRUEBAS",
                            "405282",
                            "1011",
                            "09",
                            "16",
                            "SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A.",
                            ""
                        ),
                        TransactionStatus::SUCCESS()
                    ),
                    new Transaction(
                        "9F9C4A90-7920-4E5A-B883-3F649883EC7C",
                        "2016-06-02T12:28:01.620Z",
                        "2016-06-02T12:28:01+0200",
                        Operative::REFUND(),
                        200,
                        "4321",
                        "NONE",
                        new Card(
                            "CARD",
                            "ABAB111A-CCCC-AAE3-C222A81EC8F9F",
                            CardType::C(),
                            "c734c643edfdccf3555a157fbf7ccb08006fbb1f",
                            "VISA",
                            "ES",
                            "TITULAR DE PRUEBAS",
                            "405282",
                            "1011",
                            "09",
                            "16",
                            "SERVIRED, SOCIEDAD ESPANOLA DE MEDIOS DE PAGO, S.A.",
                            ""
                        ),
                        TransactionStatus::SUCCESS()
                    )
                ],
                "66f8c4bbfff15d006f253e34a8d9611a",
                "43.12.121.88",
                "73628819B",
                ""
            ),
            new Client("412431F0-F23F-16BA-A854-BD01E8593E2E"),
            new PaymentOrderExtraData(new Payment(3))
        );
        $actual = $this->paylandsClient->getOrder($request);
        $this->assertEquals($expected, $actual);
    }
}
