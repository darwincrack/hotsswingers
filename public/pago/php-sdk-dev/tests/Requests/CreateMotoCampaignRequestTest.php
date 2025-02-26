<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\CreateMotoCampaignRequest;
use PaylandsSDK\Types\Enums\MoToCampaignType;
use PHPUnit\Framework\TestCase;

class CreateMotoCampaignRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new CreateMotoCampaignRequest(
            "subject",
            "description",
            "service uuid",
            MoToCampaignType::CUSTOM_DELIVERY(),
            "2020-03-04",
            "content",
            "filename.csv"
        );
        $this->assertEquals("subject", $request->getSubject());
        $this->assertEquals("description", $request->getDescription());
        $this->assertEquals("service uuid", $request->getServiceUuid());
        $this->assertEquals(MoToCampaignType::CUSTOM_DELIVERY(), $request->getType());
        $this->assertEquals("2020-03-04", $request->getExpiresAt());
        $this->assertEquals("content", $request->getFile());
        $this->assertEquals("filename.csv", $request->getFilename());
    }

    /**
 * @return void
 */
    public function test__construct_without_optional_args()
    {
        $request = new CreateMotoCampaignRequest(
            "subject",
            "description",
            "service uuid",
            MoToCampaignType::CUSTOM_DELIVERY(),
            "2020-03-04",
            "content"
        );
        $this->assertEquals("subject", $request->getSubject());
        $this->assertEquals("description", $request->getDescription());
        $this->assertEquals("service uuid", $request->getServiceUuid());
        $this->assertEquals(MoToCampaignType::CUSTOM_DELIVERY(), $request->getType());
        $this->assertEquals("2020-03-04", $request->getExpiresAt());
        $this->assertEquals("content", $request->getFile());
        $this->assertNull($request->getFilename());
    }
}
