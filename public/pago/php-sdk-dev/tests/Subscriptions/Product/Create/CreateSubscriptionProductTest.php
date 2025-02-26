<?php

namespace PaylandsSDK\Tests\Subscriptions\Product\Create;

use PaylandsSDK\Requests\CreateSubscriptionProductRequest;
use PaylandsSDK\Responses\CreateSubscriptionProductResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\SubscriptionProduct;
use PaylandsSDK\Utils\HttpResponse;

class CreateSubscriptionProductTest extends TestBase
{
    /**
 * @return void
 */
    public function test_createSubscriptionProduct_ok()
    {
        $request = new CreateSubscriptionProductRequest(
            "Real product",
            "product",
            false,
            "https://yourdomain.com/subscriptions/notify"
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('POST', 'subscriptions/product', ["json" => array_merge(["signature" => ""], $request->parseRequest())])
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new CreateSubscriptionProductResponse(
            "OK",
            200,
            "2019-12-04T15:29:10+0100",
            new SubscriptionProduct(
                "Real product",
                "product",
                false,
                "https://yourdomain.com/subscriptions/notify",
                "2019-12-04 15:29:10",
                "2019-12-04 15:29:10"
            )
        );

        $actual = $this->paylandsClient->createSubscriptionProduct($request);

        $this->assertEquals($expected, $actual);
    }
}
