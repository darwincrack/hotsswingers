<?php

namespace PaylandsSDK\Tests\Customer\Address\Get;

use PaylandsSDK\Requests\GetCustomerAddressRequest;
use PaylandsSDK\Responses\GetCustomerAddressResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\CustomerAddress;
use PaylandsSDK\Types\Enums\AddressType;
use PaylandsSDK\Utils\HttpResponse;

class GetCustomerAddressTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getCustomerAddressTest_ok()
    {
        $request = new GetCustomerAddressRequest("123456");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "GET",
                "customer/address/" .$request->getUuid()
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new GetCustomerAddressResponse(
            "OK",
            200,
            "2019-11-19T16:58:57+0100",
            new CustomerAddress(
                "B7B20B82-0112-464F-BE0F-2905BA84CDED",
                "Ronda",
                "Magdalena",
                "número 20",
                "Castellón",
                "Castellón",
                "ESP",
                "12006",
                AddressType::OTHER(),
                true
            )
        );
        $actual = $this->paylandsClient->getCustomerAddress($request);
        $this->assertEquals($expected, $actual);
    }
}
