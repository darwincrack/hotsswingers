<?php

namespace PaylandsSDK\Tests\Customer\Profile\Update;

use PaylandsSDK\Requests\UpdateCustomerProfileRequest;
use PaylandsSDK\Responses\UpdateCustomerProfileResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\CustomerProfile;
use PaylandsSDK\Types\Enums\DocumentIdentificationIssuer;
use PaylandsSDK\Types\Enums\DocumentIdentificationType;
use PaylandsSDK\Types\Phone;
use PaylandsSDK\Utils\HttpResponse;

class UpdateCustomerProfileTest extends TestBase
{
    /**
 * @return void
 */
    public function test_updateCustomerProfileTest_ok()
    {
        $request = new UpdateCustomerProfileRequest(
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
                "PUT",
                "customer/profile",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new UpdateCustomerProfileResponse(
            "OK",
            200,
            "2019-11-19T15:04:39+0100",
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
                "2019-11-19 15:04:39",
                "2019-11-19 15:04:39",
                null,
                new Phone(),
                new Phone("654123789", "123"),
                new Phone("321654987"),
                new Phone("87654132", "333")
            )
        );
        $actual = $this->paylandsClient->updateCustomerProfile($request);
        $this->assertEquals($expected, $actual);
    }
}
