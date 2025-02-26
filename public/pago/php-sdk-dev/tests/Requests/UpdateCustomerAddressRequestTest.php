<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\UpdateCustomerAddressRequest;
use PaylandsSDK\Types\Enums\AddressType;
use PHPUnit\Framework\TestCase;

class UpdateCustomerAddressRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new UpdateCustomerAddressRequest(
            "uuid",
            "external_id",
            "address1",
            "city",
            "state_code",
            "country",
            "zip_code",
            AddressType::SHIPPING(),
            true,
            "address2",
            "address3"
        );
        $this->assertEquals("external_id", $request->getExternalId());
        $this->assertEquals("address1", $request->getAddress1());
        $this->assertEquals("city", $request->getCity());
        $this->assertEquals("state_code", $request->getStateCode());
        $this->assertEquals("country", $request->getCountry());
        $this->assertEquals(AddressType::SHIPPING(), $request->getType());
        $this->assertEquals("zip_code", $request->getZipCode());
        $this->assertEquals("address2", $request->getAddress2());
        $this->assertEquals("address3", $request->getAddress3());
        $this->assertTrue($request->isDefault());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new UpdateCustomerAddressRequest(
            "uuid",
            "external_id",
            "address1",
            "city",
            "state_code",
            "country",
            "zip_code",
            AddressType::SHIPPING()
        );
        $this->assertEquals("external_id", $request->getExternalId());
        $this->assertEquals("address1", $request->getAddress1());
        $this->assertEquals("city", $request->getCity());
        $this->assertEquals("state_code", $request->getStateCode());
        $this->assertEquals("country", $request->getCountry());
        $this->assertEquals(AddressType::SHIPPING(), $request->getType());
        $this->assertEquals("zip_code", $request->getZipCode());
        $this->assertNull($request->getAddress2());
        $this->assertNull($request->getAddress3());
        $this->assertFalse($request->isDefault());
    }
}
