<?php

namespace PaylandsSDK\Tests\Customer\Profile\Get;

use PaylandsSDK\Requests\GetCustomerProfileRequest;
use PaylandsSDK\Responses\GetCustomerProfileResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\CustomerProfile;
use PaylandsSDK\Types\Enums\DocumentIdentificationIssuer;
use PaylandsSDK\Types\Enums\DocumentIdentificationType;
use PaylandsSDK\Types\Phone;
use PaylandsSDK\Utils\HttpResponse;

class GetCustomerProfileTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getCustomerProfileTest_ok()
    {
        $request = new GetCustomerProfileRequest("123456");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "GET",
                "customer/profile/" . $request->getExternalId()
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));

        $expected = new GetCustomerProfileResponse(
            "OK",
            200,
            "2019-11-19T15:09:31+0100",
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
        $actual = $this->paylandsClient->getCustomerProfile($request);
        $this->assertEquals($expected, $actual);
    }
}
