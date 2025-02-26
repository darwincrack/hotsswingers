<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\SendRefundsFileRequest;
use PHPUnit\Framework\TestCase;

class SendRefundsFileRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new SendRefundsFileRequest(
            "filename",
            "data",
            "2020-02-02"
        );
        $this->assertEquals("filename", $request->getFilename());
        $this->assertEquals("data", $request->getData());
        $this->assertEquals("2020-02-02", $request->getExecuteAt());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new SendRefundsFileRequest("filename", "data");
        $this->assertEquals("filename", $request->getFilename());
        $this->assertEquals("data", $request->getData());
        $this->assertNull($request->getExecuteAt());
    }
}
