<?php

namespace PaylandsSDK\Tests\Subscriptions\Plan\Get;

use PaylandsSDK\Responses\GetSubscriptionPlansResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Enums\SubscriptionInterval;
use PaylandsSDK\Types\SubscriptionPlan;
use PaylandsSDK\Types\SubscriptionProduct;
use PaylandsSDK\Utils\HttpResponse;

class GetSubscriptionPlansTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getSubscriptionPlans_ok()
    {
        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'subscriptions/plans')
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new GetSubscriptionPlansResponse(
            "OK",
            200,
            "2019-12-04T16:55:28+0100",
            [
                new SubscriptionPlan(
                    "Real plan name",
                    "plan",
                    499,
                    1,
                    SubscriptionInterval::DAILY(),
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
            ]
        );

        $actual = $this->paylandsClient->getSubscriptionPlans();

        $this->assertEquals($expected, $actual);
    }
}
