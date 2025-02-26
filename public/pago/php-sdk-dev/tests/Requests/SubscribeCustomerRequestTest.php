<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\SubscribeCustomerRequest;
use PaylandsSDK\Requests\SubscriptionAdditionalData;
use PaylandsSDK\Types\Enums\Operative;
use PHPUnit\Framework\TestCase;

class SubscribeCustomerRequestTest extends TestCase
{
    private $additional_data;

    protected function setUp()
    {
        parent::setUp();
        $this->additional_data = new SubscriptionAdditionalData(
            Operative::AUTHORIZATION(),
            "source uuid",
            "customer id",
            "service"
        );
    }


    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new SubscribeCustomerRequest(
            "customer",
            "plan",
            100,
            34,
            "2020-01-01",
            $this->additional_data
        );
        $this->assertEquals("customer", $request->getCustomer());
        $this->assertEquals("plan", $request->getPlan());
        $this->assertEquals(100, $request->getTotalPaymentNumber());
        $this->assertEquals(34, $request->getPaymentAttemptsLimit());
        $this->assertEquals("2020-01-01", $request->getInitialDate());
        $this->assertEquals($this->additional_data, $request->getAdditionalData());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new SubscribeCustomerRequest(
            "customer",
            "plan",
            100,
            34
        );
        $this->assertEquals("customer", $request->getCustomer());
        $this->assertEquals("plan", $request->getPlan());
        $this->assertEquals(100, $request->getTotalPaymentNumber());
        $this->assertEquals(34, $request->getPaymentAttemptsLimit());
        $this->assertNull($request->getInitialDate());
        $this->assertNull($request->getAdditionalData());
    }
}
