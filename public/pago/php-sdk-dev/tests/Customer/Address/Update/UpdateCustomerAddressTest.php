<?php

namespace PaylandsSDK\Tests\Customer\Address\Update;

use PaylandsSDK\Requests\UpdateCustomerAddressRequest;
use PaylandsSDK\Responses\UpdateCustomerAddressResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\CustomerAddress;
use PaylandsSDK\Types\Enums\AddressType;
use PaylandsSDK\Utils\HttpResponse;

class UpdateCustomerAddressTest extends TestBase
{
    /**
 * @return void
 */
    public function test_updateCustomerAddressTest_ok()
    {
        $request = new UpdateCustomerAddressRequest(
            "addr uuid",
            "123456",
            "Ronda",
            "Castellón",
            "Castellón",
            "ESP",
            "120006",
            AddressType::OTHER()
        );
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "PUT",
                "customer/address",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new UpdateCustomerAddressResponse(
            "OK",
            200,
            "2019-11-19T16:54:54+0100",
            new Customer("12345678A"),
            new CustomerAddress(
                "B7B20B82-0112-464F-BE0F-2905BA84CDED",
                "Ronda",
                "Magdalena",
                "número 20",
                "Castellón",
                "Castellón",
                "ESP",
                "12006",
                null,
                true
            )
        );
        $actual = $this->paylandsClient->updateCustomerAddress($request);
        $this->assertEquals($expected, $actual);
    }
}
