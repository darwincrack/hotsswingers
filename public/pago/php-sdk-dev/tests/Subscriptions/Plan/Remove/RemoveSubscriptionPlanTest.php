<?php

namespace PaylandsSDK\Tests\Subscriptions\Plan\Remove;

use PaylandsSDK\Requests\RemoveSubscriptionPlanRequest;
use PaylandsSDK\Responses\RemoveSubscriptionPlanResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Utils\HttpResponse;

class RemoveSubscriptionPlanTest extends TestBase
{
    /**
 * @return void
 */
    public function test_removeSubscriptionPlan_ok()
    {
        $request = new RemoveSubscriptionPlanRequest(
            "plan_external_id"
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('DELETE', 'subscriptions/plan/'.$request->getPlanExternalId())
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new RemoveSubscriptionPlanResponse(
            "OK",
            200,
            "2019-12-04T16:30:29+0100",
            1
        );

        $actual = $this->paylandsClient->removeSubscriptionPlan($request);

        $this->assertEquals($expected, $actual);
    }
}
