<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\CreateSubscriptionPlanRequest;
use PaylandsSDK\Types\Enums\SubscriptionInterval;
use PHPUnit\Framework\TestCase;

class CreateSubscriptionPlanRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new CreateSubscriptionPlanRequest(
            "name",
            "external id",
            "product",
            5,
            4,
            SubscriptionInterval::DAILY(),
            true,
            51,
            SubscriptionInterval::YEARLY()
        );
        $this->assertEquals("name", $request->getName());
        $this->assertEquals("external id", $request->getExternalId());
        $this->assertEquals("product", $request->getProduct());
        $this->assertEquals(5, $request->getAmount());
        $this->assertEquals(4, $request->getInterval());
        $this->assertEquals(SubscriptionInterval::DAILY(), $request->getIntervalType());
        $this->assertTrue($request->isTrialAvailable());
        $this->assertEquals(51, $request->getIntervalOffset());
        $this->assertEquals(SubscriptionInterval::YEARLY(), $request->getIntervalOffsetType());
    }

    /**
 * @return void
 */
    public function test__construct_without_optional_args()
    {
        $request = new CreateSubscriptionPlanRequest(
            "name",
            "external id",
            "product",
            5,
            4,
            SubscriptionInterval::DAILY()
        );
        $this->assertEquals("name", $request->getName());
        $this->assertEquals("external id", $request->getExternalId());
        $this->assertEquals("product", $request->getProduct());
        $this->assertEquals(5, $request->getAmount());
        $this->assertEquals(4, $request->getInterval());
        $this->assertEquals(SubscriptionInterval::DAILY(), $request->getIntervalType());
        $this->assertFalse($request->isTrialAvailable());
        $this->assertEquals(0, $request->getIntervalOffset());
        $this->assertNull($request->getIntervalOffsetType());
    }
}
