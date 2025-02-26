<?php

namespace PaylandsSDK\Tests\Subscriptions\Remove;

use PaylandsSDK\Requests\RemoveSubscriptionRequest;
use PaylandsSDK\Responses\RemoveSubscriptionResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Utils\HttpResponse;

class RemoveSubscriptionTest extends TestBase
{
    /**
 * @return void
 */
    public function test_removeSubscription_ok()
    {
        $request = new RemoveSubscriptionRequest(
            "subscription_id"
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('DELETE', 'subscriptions/subscription/'.$request->getSubscriptionId())
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new RemoveSubscriptionResponse(
            "OK",
            200,
            "2019-12-04T17:40:46+0100",
            1
        );

        $actual = $this->paylandsClient->removeSubscription($request);

        $this->assertEquals($expected, $actual);
    }
}
