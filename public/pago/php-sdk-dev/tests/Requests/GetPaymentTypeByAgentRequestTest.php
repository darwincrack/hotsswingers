<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\GetPaymentTypeByAgentRequest;
use PHPUnit\Framework\TestCase;

class GetPaymentTypeByAgentRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new GetPaymentTypeByAgentRequest("service uuid", "pay agent cd");
        $this->assertEquals("service uuid", $request->getServiceUuid());
        $this->assertEquals("pay agent cd", $request->getPayAgentCd());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new GetPaymentTypeByAgentRequest("service uuid");
        $this->assertEquals("service uuid", $request->getServiceUuid());
        $this->assertNull($request->getPayAgentCd());
    }
}
