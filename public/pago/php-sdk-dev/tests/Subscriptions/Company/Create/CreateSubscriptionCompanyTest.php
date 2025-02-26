<?php

namespace PaylandsSDK\Tests\Subscriptions\Company\Create;

use PaylandsSDK\Responses\CreateSubscriptionCompanyResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\SubscriptionCompany;
use PaylandsSDK\Utils\HttpResponse;

class CreateSubscriptionCompanyTest extends TestBase
{
    /**
 * @return void
 */
    public function test_createSubscriptionCompany_ok()
    {
        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('POST', 'subscriptions/company')
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new CreateSubscriptionCompanyResponse(
            "OK",
            200,
            "2019-12-04T11:59:41+0100",
            new SubscriptionCompany(
                "Paylands Admin",
                "B8A48789-8AF0-47D1-9116-35AB0A941121",
                "2019-12-04 11:59:41",
                "2019-12-04 11:59:41"
            )
        );

        $actual = $this->paylandsClient->createSubscriptionCompany();

        $this->assertEquals($expected, $actual);
    }
}
