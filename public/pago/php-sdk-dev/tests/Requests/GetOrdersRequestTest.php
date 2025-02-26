<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\GetOrdersRequest;
use PHPUnit\Framework\TestCase;

class GetOrdersRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new GetOrdersRequest("start", "end", "terminal");
        $this->assertEquals("start", $request->getStart());
        $this->assertEquals("end", $request->getEnd());
        $this->assertEquals("terminal", $request->getTerminal());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new GetOrdersRequest();
        $this->assertNull($request->getStart());
        $this->assertNull($request->getEnd());
        $this->assertNull($request->getTerminal());
    }
}
