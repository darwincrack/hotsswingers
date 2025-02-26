<?php

namespace PaylandsSDK\Tests\Subscriptions\Product\Get;

use PaylandsSDK\Responses\GetSubscriptionProductsResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\SubscriptionProduct;
use PaylandsSDK\Utils\HttpResponse;

class GetSubscriptionProductsTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getSubscriptionProductsTest_ok()
    {
        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'subscriptions/products')
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new GetSubscriptionProductsResponse(
            "OK",
            200,
            "2019-12-04T15:29:12+0100",
            [
                new SubscriptionProduct(
                    "Sandbox product",
                    "test_product",
                    true,
                    "https://yourdomain.com/subscriptions/notify",
                    "2019-12-04 15:28:55",
                    "2019-12-04 15:28:55"
                ),
                new SubscriptionProduct(
                    "Real product",
                    "product",
                    false,
                    "https://yourdomain.com/subscriptions/notify",
                    "2019-12-04 15:29:10",
                    "2019-12-04 15:29:10"
                )
            ]
        );

        $actual = $this->paylandsClient->getSubscriptionProducts();

        $this->assertEquals($expected, $actual);
    }
}
