<?php

namespace PaylandsSDK\Tests\Customer\Profile\Create;

use PaylandsSDK\Requests\CreateCustomerProfileRequest;
use PaylandsSDK\Responses\CreateCustomerProfileResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\CustomerProfile;
use PaylandsSDK\Types\Enums\DocumentIdentificationIssuer;
use PaylandsSDK\Types\Enums\DocumentIdentificationType;
use PaylandsSDK\Types\Phone;
use PaylandsSDK\Utils\HttpResponse;

class CreateCustomerProfileTest extends TestBase
{
    /**
 * @return void
 */
    public function test_createCustomerProfileTest_ok()
    {
        $request = new CreateCustomerProfileRequest(
            "123456789A",
            'John',
            'Doe',
            DocumentIdentificationIssuer::STATE_GOVERNMENT(),
            DocumentIdentificationType::NATIONAL_IDENTITY_DOCUMENT(),
            "12345678Z",
            "2020-02-02",
            "Salary",
            "Shoe Machine Operators",
            "12345",
            "John Doe",
            new Phone("3214321", "121"),
            new Phone("3214322", "122"),
            new Phone("3214323", "123"),
            new Phone("3214324", "124")
        );

        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "customer/profile",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new CreateCustomerProfileResponse(
            "OK",
            200,
            "2019-11-19T14:06:39+0100",
            new Customer("12345678A"),
            new CustomerProfile(
                "Saville J",
                "Dulce Armentrout",
                "Saville J Dulce Armentrout",
                DocumentIdentificationIssuer::FEDERAL_GOVERNMENT(),
                DocumentIdentificationType::NATIONAL_IDENTITY_DOCUMENT(),
                "12345678Z",
                "1971-08-05",
                "Salary",
                "Shoe Machine Operators",
                "503-33-4388",
                "2019-11-19 14:06:38",
                "2019-11-19 14:06:38",
                null,
                new Phone(),
                new Phone("654123789", "123"),
                new Phone("321654987"),
                new Phone("87654132", "333")
            )
        );
        $actual = $this->paylandsClient->createCustomerProfile($request);
        $this->assertEquals($expected, $actual);
    }
}
