<?php

namespace PaylandsSDK\Tests\Subscriptions\Customer\Subscribe;

use PaylandsSDK\Requests\SubscribeCustomerRequest;
use PaylandsSDK\Requests\SubscriptionAdditionalData;
use PaylandsSDK\Responses\SubscribeCustomerResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Enums\Operative;
use PaylandsSDK\Types\Enums\SubscriptionInterval;
use PaylandsSDK\Types\Enums\SubscriptionPaymentStatus;
use PaylandsSDK\Types\Enums\SubscriptionStatus;
use PaylandsSDK\Types\Subscription;
use PaylandsSDK\Types\SubscriptionPayment;
use PaylandsSDK\Types\SubscriptionPlan;
use PaylandsSDK\Types\SubscriptionProduct;
use PaylandsSDK\Utils\HttpResponse;

class SubscribeCustomerTest extends TestBase
{
    /**
 * @return void
 */
    public function test_subscribeCustomer_ok()
    {
        $request = new SubscribeCustomerRequest(
            "customer name",
            "plan",
            3,
            3,
            "2019",
            new SubscriptionAdditionalData(
                Operative::AUTHORIZATION(),
                "C10721E7-1404-45DC-8762-351DD9945D1D",
                "customer322",
                "60A1F4C0-CC58-47A9-A0B9-868F9EF29045",
                "Datos extra",
                "https://yourdomain.com/subscriptions/notify"
            )
        );

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('POST', 'subscriptions/subscription', ["json" => array_merge(["signature" => ""], $request->parseRequest())])
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new SubscribeCustomerResponse(
            "OK",
            200,
            "2019-12-04T17:38:11+0100",
            new Subscription(
                "5de7e0f3f8956d1ca1cf7f18",
                true,
                SubscriptionStatus::CREATED(),
                3,
                0,
                3,
                "2019-12-16 00:00:00",
                "2019-12-16 00:00:00",
                "{\"operative\":\"AUTHORIZATION\",\"source_uuid\":\"24ABB0C6-8A8F-4ED8-BF72-2FB0D65ABD78\",\"customer_ext_id\":\"customer name\",\"service\":\"60A1F4C0-CC58-47A9-A0B9-868F9EF29045\",\"url_post\":\"https:\\/\\/yourdomain.com\\/subscriptions\\/notify\"}",
                "2019-12-04 17:38:11",
                "2019-12-04 17:38:11",
                new SubscriptionPlan(
                    "Real plan name",
                    "plan",
                    499,
                    1,
                    SubscriptionInterval::MONTHLY(),
                    true,
                    "2019-12-04 17:38:08",
                    "2019-12-04 17:38:08",
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
                ),
                [
                    new SubscriptionPayment(
                        "5e53b9c5af035032bbd09e8a",
                        SubscriptionPaymentStatus::CREATED(),
                        "2019-12-16",
                        1,
                        1,
                        499,
                        "2019-12-16 00:00:00",
                        "2019-12-16 00:00:00",
                        null
                    )
                ]
            )
        );

        $actual = $this->paylandsClient->subscribeCustomer($request);

        $this->assertEquals($expected, $actual);
    }
}
