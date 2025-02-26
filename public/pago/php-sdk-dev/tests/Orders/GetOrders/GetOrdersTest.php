<?php

namespace PaylandsSDK\Tests\Orders\GetOrders;

use PaylandsSDK\Requests\GetOrdersRequest;
use PaylandsSDK\Responses\GetOrdersResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Enums\TransactionStatus;
use PaylandsSDK\Types\TransactionOrder;
use PaylandsSDK\Utils\HttpResponse;

class GetOrdersTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getOrdersTest_ok()
    {
        $request = new GetOrdersRequest(
            "202001010000",
            "202002010000",
            "65432781"
        );
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "GET",
                "orders",
                ["query" => $request->parseRequest()]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new GetOrdersResponse(
            "OK",
            200,
            "2017-01-01T00:00:00+0200",
            2,
            [
                new TransactionOrder(
                    "3D7F0388-5297-460F-BA8A-6CE98116BD6D",
                    "2C1DE2D5-3246-4E4A-85B4-EA79BBA14674",
                    "C1EC8E8B-7DB8-4E5F-BA79-4137A6CF1D97",
                    null,
                    "MASTERCARD",
                    "John Doe",
                    "724",
                    "11b6940274ae453735e1776b5fe5be123e1ca552",
                    "480002****2014",
                    "SANTANDER",
                    "2016-11-11 00:33:06",
                    12045,
                    "000000214339",
                    TransactionStatus::SUCCESS(),
                    "NONE",
                    "512637",
                    "7CDF21C5-2570-47C9-B2E2-57E8A09628AF",
                    "AUTHORIZATION",
                    "1.2.3.4",
                    "500046006,test",
                    "3366558877",
                    "card123223",
                    null,
                    "840"
                ),
                new TransactionOrder(
                    "3D7F0388-5297-460F-BA8A-6CE98116BD6D",
                    "2C1DE2D5-3246-4E4A-85B4-EA79BBA14674",
                    "C1EC8E8B-7DB8-4E5F-BA79-4137A6CF1D97",
                    null,
                    "BANKIA",
                    "John Doe",
                    "724",
                    "11b6940274ae453735e1776b5fe5be123e1ca552",
                    "480002****2014",
                    "SANTANDER",
                    "2016-11-11 00:33:06",
                    32045,
                    "000000714331",
                    TransactionStatus::REFUSED(),
                    "0190",
                    "",
                    "543F21C5-2570-47C9-B2E2-57E8A09628AF",
                    "AUTHORIZATION",
                    "1.2.3.4",
                    "55443322,test",
                    "3366558877",
                    null,
                    null,
                    "840"
                )
            ]
        );
        $actual = $this->paylandsClient->getOrders($request);
        $this->assertEquals($expected, $actual);
    }
}
