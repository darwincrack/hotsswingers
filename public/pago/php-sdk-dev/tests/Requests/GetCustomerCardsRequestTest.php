<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\GetCustomerCardsRequest;
use PaylandsSDK\Types\Enums\CardStatus;
use PHPUnit\Framework\TestCase;

class GetCustomerCardsRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new GetCustomerCardsRequest("customer id", CardStatus::ALL(), true);

        $this->assertEquals("customer id", $request->getCustomerExtId());
        $this->assertEquals(CardStatus::ALL(), $request->getStatus());
        $this->assertTrue($request->isUnique());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new GetCustomerCardsRequest("customer id");

        $this->assertEquals("customer id", $request->getCustomerExtId());
        $this->assertNull($request->getStatus());
        $this->assertFalse($request->isUnique());
    }
}
