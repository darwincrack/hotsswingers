<?php

namespace PaylandsSDK\Tests\Payments\SendOneStepPayment;

use PaylandsSDK\Requests\Payment;
use PaylandsSDK\Requests\PaymentOrderExtraData;
use PaylandsSDK\Requests\SendOneStepPaymentRequest;
use PaylandsSDK\Responses\SendOneStepPaymentResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Client;
use PaylandsSDK\Types\Enums\Operative;
use PaylandsSDK\Types\Enums\OrderStatus;
use PaylandsSDK\Types\Order;
use PaylandsSDK\Utils\HttpResponse;

class SendOneStepPaymentTest extends TestBase
{
    /**
 * @return void
 */
    public function test_sendOneStepPaymentTest_ok()
    {
        $request = new SendOneStepPaymentRequest(
            400,
            Operative::AUTHORIZATION(),
            "user1024",
            "usuario1234",
            "98edf02d4aa94abbd4a92c",
            true,
            "https://mysite.com/payment/result",
            "https://mysite.com/payment/success",
            "https://mysite.com/payment/error",
            "6a93c26e-954d-47ea-83bf-21fa29b68f28",
            "order's description",
            "John Doe",
            "4111111111111111",
            "19",
            "12",
            "card12345",
            "123"
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                'POST',
                'charge',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new SendOneStepPaymentResponse(
            "OK",
            200,
            "2018-04-18T09:10:41+0200",
            new Order(
                "AB1ECA33-4566-4C2F-AC6C-6259E23D53D1",
                "2018-04-18T09:10:41+0200",
                "2018-04-18T09:10:41+0200",
                400,
                "978",
                false,
                false,
                0,
                "REDSYS",
                OrderStatus::CREATED(),
                [],
                "082a593dcccf5f3f37a563815659d4316154dff7f8139fabaa98bdffe9ce4375c5f9bb60825d1585738",
                null,
                null,
                ""
            ),
            new Client("818431F0-F23F-47EA-A854-BD01E8593E2E"),
            new PaymentOrderExtraData(new Payment(3))
        );

        $actual = $this->paylandsClient->sendOneStepPayment($request);

        $this->assertEquals($expected, $actual);
    }
}
