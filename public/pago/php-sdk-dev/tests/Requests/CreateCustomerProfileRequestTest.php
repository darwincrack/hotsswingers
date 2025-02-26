<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\CreateCustomerProfileRequest;
use PaylandsSDK\Types\Enums\DocumentIdentificationIssuer;
use PaylandsSDK\Types\Enums\DocumentIdentificationType;
use PaylandsSDK\Types\Phone;
use PHPUnit\Framework\TestCase;

class CreateCustomerProfileRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $phone = new Phone("123456", "123");
        $work_phone = new Phone("102030", "246");
        $home_phone = new Phone("405060", "369");
        $mobile_phone = new Phone("708090", "789");
        $request = new CreateCustomerProfileRequest(
            "external id",
            "first name",
            "last name",
            DocumentIdentificationIssuer::FEDERAL_GOVERNMENT(),
            DocumentIdentificationType::DRIVER_LICENSE(),
            "12345678",
            "2020-03-04",
            "salary",
            "occupation",
            "987654",
            "cardholder name",
            $phone,
            $work_phone,
            $home_phone,
            $mobile_phone
        );

        $this->assertEquals("external id", $request->getExternalId());
        $this->assertEquals("first name", $request->getFirstName());
        $this->assertEquals("last name", $request->getLastName());
        $this->assertEquals(DocumentIdentificationIssuer::FEDERAL_GOVERNMENT(), $request->getDocumentIdentificationIssuerType());
        $this->assertEquals(DocumentIdentificationType::DRIVER_LICENSE(), $request->getDocumentIdentificationType());
        $this->assertEquals("12345678", $request->getDocumentIdentificationNumber());
        $this->assertEquals("2020-03-04", $request->getBirthDate());
        $this->assertEquals("salary", $request->getSourceOfFunds());
        $this->assertEquals("occupation", $request->getOccupation());
        $this->assertEquals("987654", $request->getSocialSecurityNumber());
        $this->assertEquals("cardholder name", $request->getCardholderName());
        $this->assertEquals($phone, $request->getPhone());
        $this->assertEquals($work_phone, $request->getWorkPhone());
        $this->assertEquals($home_phone, $request->getHomePhone());
        $this->assertEquals($mobile_phone, $request->getMobilePhone());
    }

    /**
 * @return void
 */
    public function test__construct_without_optional_args()
    {
        $request = new CreateCustomerProfileRequest(
            "external id",
            "first name",
            "last name",
            DocumentIdentificationIssuer::FEDERAL_GOVERNMENT(),
            DocumentIdentificationType::DRIVER_LICENSE(),
            "12345678",
            "2020-03-04",
            "salary",
            "occupation",
            "987654"
        );

        $this->assertEquals("external id", $request->getExternalId());
        $this->assertEquals("first name", $request->getFirstName());
        $this->assertEquals("last name", $request->getLastName());
        $this->assertEquals(DocumentIdentificationIssuer::FEDERAL_GOVERNMENT(), $request->getDocumentIdentificationIssuerType());
        $this->assertEquals(DocumentIdentificationType::DRIVER_LICENSE(), $request->getDocumentIdentificationType());
        $this->assertEquals("12345678", $request->getDocumentIdentificationNumber());
        $this->assertEquals("2020-03-04", $request->getBirthDate());
        $this->assertEquals("salary", $request->getSourceOfFunds());
        $this->assertEquals("occupation", $request->getOccupation());
        $this->assertEquals("987654", $request->getSocialSecurityNumber());
        $this->assertNull($request->getCardholderName());
        $this->assertNull($request->getPhone());
        $this->assertNull($request->getWorkPhone());
        $this->assertNull($request->getHomePhone());
        $this->assertNull($request->getMobilePhone());
    }
}
