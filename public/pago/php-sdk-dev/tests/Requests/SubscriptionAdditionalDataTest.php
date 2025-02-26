<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\SubscriptionAdditionalData;
use PaylandsSDK\Types\Enums\Operative;
use PHPUnit\Framework\TestCase;

class SubscriptionAdditionalDataTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new SubscriptionAdditionalData(
            Operative::AUTHORIZATION(),
            "source_uuid",
            "customer_ext_id",
            "service",
            "additional",
            "url_post"
        );
        $this->assertEquals(Operative::AUTHORIZATION(), $request->getOperative());
        $this->assertEquals("source_uuid", $request->getSourceUuid());
        $this->assertEquals("customer_ext_id", $request->getCustomerExtId());
        $this->assertEquals("service", $request->getService());
        $this->assertEquals("additional", $request->getAdditional());
        $this->assertEquals("url_post", $request->getUrlPost());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new SubscriptionAdditionalData(
            Operative::AUTHORIZATION(),
            "source_uuid",
            "customer_ext_id",
            "service"
        );
        $this->assertEquals(Operative::AUTHORIZATION(), $request->getOperative());
        $this->assertEquals("source_uuid", $request->getSourceUuid());
        $this->assertEquals("customer_ext_id", $request->getCustomerExtId());
        $this->assertEquals("service", $request->getService());
        $this->assertNull($request->getAdditional());
        $this->assertNull($request->getUrlPost());
    }
}
