<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\SetCardDescriptionRequest;
use PHPUnit\Framework\TestCase;

class SetCardDescriptionRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new SetCardDescriptionRequest("source uuid", "additional");
        $this->assertEquals("source uuid", $request->getSourceUuid());
        $this->assertEquals("additional", $request->getAdditional());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new SetCardDescriptionRequest("source uuid");
        $this->assertEquals("source uuid", $request->getSourceUuid());
        $this->assertNull($request->getAdditional());
    }
}
