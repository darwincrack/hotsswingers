<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\CreateSubscriptionProductRequest;
use PHPUnit\Framework\TestCase;

class CreateSubscriptionProductRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new CreateSubscriptionProductRequest(
            "name",
            "external id",
            true,
            "notification url"
        );
        $this->assertEquals("name", $request->getName());
        $this->assertEquals("external id", $request->getExternalId());
        $this->assertTrue($request->isSandbox());
        $this->assertEquals("notification url", $request->getNotificationUrl());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new CreateSubscriptionProductRequest("name", "external id");
        $this->assertEquals("name", $request->getName());
        $this->assertEquals("external id", $request->getExternalId());
        $this->assertFalse($request->isSandbox());
        $this->assertNull($request->getNotificationUrl());
    }
}
