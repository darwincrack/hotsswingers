<?php

namespace PaylandsSDK\Tests\Subscriptions\Plan\Create;

use PaylandsSDK\Requests\CreateSubscriptionPlanRequest;
use PaylandsSDK\Responses\CreateSubscriptionPlanResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Enums\SubscriptionInterval;
use PaylandsSDK\Types\SubscriptionPlan;
use PaylandsSDK\Types\SubscriptionProduct;
use PaylandsSDK\Utils\HttpResponse;

class CreateSubscriptionPlanTest extends TestBase
{
    /**
 * @return void
 */
    public function test_createSubscriptionPlan_ok()
    {
        $request = new CreateSubscriptionPlanRequest(
            "Real product",
            "plan",
            "product",
            499,
            1,
            SubscriptionInterval::DAILY(),
            true,
            1,
            SubscriptionInterval::DAILY()
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'subscriptions/plan',
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new CreateSubscriptionPlanResponse(
            "OK",
            200,
            "2019-12-04T16:30:29+0100",
            new SubscriptionPlan(
                "Real plan name",
                "plan",
                499,
                1,
                SubscriptionInterval::MONTHLY(),
                true,
                "2019-12-04 16:30:29",
                "2019-12-04 16:30:29",
                new SubscriptionProduct(
                    "Real product",
                    "product",
                    false,
                    "https://yourdomain.com/subscriptions/notify",
                    "2019-12-04 15:29:10",
                    "2019-12-04 15:29:10"
                ),
                1,
                SubscriptionInterval::WEEKLY()
            )
        );

        $actual = $this->paylandsClient->createSubscriptionPlan($request);

        $this->assertEquals($expected, $actual);
    }
}
