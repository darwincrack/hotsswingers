<?php

namespace PaylandsSDK\Tests\Subscriptions\Product\Remove;

use PaylandsSDK\Requests\RemoveSubscriptionProductRequest;
use PaylandsSDK\Responses\RemoveSubscriptionProductResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Utils\HttpResponse;

class RemoveSubscriptionProductTest extends TestBase
{
    /**
 * @return void
 */
    public function test_removeSubscriptionProduct_ok()
    {
        $request = new RemoveSubscriptionProductRequest(
            "product_external_id"
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('DELETE', 'subscriptions/product/'.$request->getProductExternalId())
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new RemoveSubscriptionProductResponse(
            "OK",
            200,
            "2019-12-04T15:28:25+0100",
            1
        );

        $actual = $this->paylandsClient->removeSubscriptionProduct($request);

        $this->assertEquals($expected, $actual);
    }
}
