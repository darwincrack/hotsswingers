<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\SendPaymentFileRequest;
use PHPUnit\Framework\TestCase;

class SendPaymentFileRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new SendPaymentFileRequest(
            "filename.csv",
            "data",
            "service",
            "2020-02-02"
        );
        $this->assertEquals("filename.csv", $request->getFilename());
        $this->assertEquals("data", $request->getData());
        $this->assertEquals("service", $request->getService());
        $this->assertEquals("2020-02-02", $request->getExecuteAt());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new SendPaymentFileRequest(
            "filename.csv",
            "data",
            "service"
        );
        $this->assertEquals("filename.csv", $request->getFilename());
        $this->assertEquals("data", $request->getData());
        $this->assertEquals("service", $request->getService());
        $this->assertNull($request->getExecuteAt());
    }
}
