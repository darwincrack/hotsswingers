<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\RefundRequest;
use PHPUnit\Framework\TestCase;

class RefundRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new RefundRequest("order uuid", 234);
        $this->assertEquals("order uuid", $request->getOrderUuid());
        $this->assertEquals(234, $request->getAmount());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new RefundRequest("order uuid");
        $this->assertEquals("order uuid", $request->getOrderUuid());
        $this->assertNull($request->getAmount());
    }
}
