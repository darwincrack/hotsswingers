<?php

namespace PaylandsSDK\Tests\Subscriptions\Get;

use PaylandsSDK\Responses\GetSubscriptionsResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Enums\SubscriptionInterval;
use PaylandsSDK\Types\Enums\SubscriptionPaymentStatus;
use PaylandsSDK\Types\Enums\SubscriptionStatus;
use PaylandsSDK\Types\Subscription;
use PaylandsSDK\Types\SubscriptionPayment;
use PaylandsSDK\Types\SubscriptionPlan;
use PaylandsSDK\Types\SubscriptionProduct;
use PaylandsSDK\Utils\HttpResponse;

class GetSubscriptionsTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getSubscriptions_ok()
    {
        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', 'subscriptions/subscriptions')
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new GetSubscriptionsResponse(
            "OK",
            200,
            "2019-12-05T08:42:24+0100",
            [
                new Subscription(
                    "5de7b52ac4d347306fd59ec5",
                    true,
                    SubscriptionStatus::PAID(),
                    1,
                    1,
                    1,
                    "2019-12-04 14:31:22",
                    "2019-12-04 14:31:22",
                    "{\"operative\":\"AUTHORIZATION\",\"source_uuid\":\"6A219573-128D-40FF-BD54-8C15ECE617E7\",\"customer_ext_id\":\"customer_name\",\"service\":\"01067440-6625-4350-8D43-4A7A5E83A3C4\",\"url_post\":\"https:\\/\\/yourdomain.com\\/subscriptions\\/notify\"}",
                    "2019-12-04 14:31:22",
                    "2019-12-04 14:31:24",
                    new SubscriptionPlan(
                        "Plan name",
                        "plan",
                        1,
                        1,
                        SubscriptionInterval::DAILY(),
                        false,
                        "2019-12-04 12:00:58",
                        "2019-12-04 15:28:25",
                        new SubscriptionProduct(
                            "Real product",
                            "product",
                            false,
                            "https://yourdomain.com/subscriptions/notify",
                            "2019-12-04 12:00:51",
                            "2019-12-04 15:28:25"
                        )
                    ),
                    [
                        new SubscriptionPayment(
                            "5e53b9c5af035032bbd09e8a",
                            SubscriptionPaymentStatus::PAID(),
                            "2019-12-16",
                            1,
                            1,
                            1,
                            "2019-12-04 12:00:58",
                            "2019-12-04 15:28:25",
                            "{\"order_uuid\":\"4C665F9E-2103-4299-B6C2-831EB1B6970D\",\"source_uuid\":\"9171049D-756D-476E-97A9-4658A5483116\",\"transaction_uuid\":\"B081C284-2DEE-4762-8E7B-8D67B42CF6F9\"}"
                        )
                    ]
                )
            ]
        );

        $actual = $this->paylandsClient->getSubscriptions();

        $this->assertEquals($expected, $actual);
    }
}
