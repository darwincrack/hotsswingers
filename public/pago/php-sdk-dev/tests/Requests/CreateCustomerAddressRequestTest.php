<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\CreateCustomerAddressRequest;
use PaylandsSDK\Types\Enums\AddressType;
use PHPUnit\Framework\TestCase;

class CreateCustomerAddressRequestTest extends TestCase {
    /**
     * @return void
     */
    public function test__construct_with_all_args() {
        $request = new CreateCustomerAddressRequest(
            "external id",
            "address 1",
            "city",
            "state",
            "country",
            "zip code",
            AddressType::SHIPPING(),
            "address 2",
            "address 3",
            true
        );
        $this->assertEquals("external id", $request->getExternalId());
        $this->assertEquals("address 1", $request->getAddress1());
        $this->assertEquals("city", $request->getCity());
        $this->assertEquals("state", $request->getStateCode());
        $this->assertEquals("country", $request->getCountry());
        $this->assertEquals(AddressType::SHIPPING(), $request->getType());
        $this->assertEquals("address 2", $request->getAddress2());
        $this->assertEquals("address 3", $request->getAddress3());
        $this->assertTrue($request->isDefault());
    }

    /**
     * @return void
     */
    public function test__construct_without_optional_args() {
        $request = new CreateCustomerAddressRequest(
            "external id",
            "address 1",
            "city",
            "state",
            "country",
            "zip code",
            AddressType::SHIPPING()
        );
        $this->assertEquals("external id", $request->getExternalId());
        $this->assertEquals("address 1", $request->getAddress1());
        $this->assertEquals("city", $request->getCity());
        $this->assertEquals("state", $request->getStateCode());
        $this->assertEquals("country", $request->getCountry());
        $this->assertEquals(AddressType::SHIPPING(), $request->getType());
        $this->assertNull($request->getAddress2());
        $this->assertNull($request->getAddress3());
        $this->assertFalse($request->isDefault());
    }
}
