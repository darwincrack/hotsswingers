<?php

namespace PaylandsSDK\Tests\Customer\Address\Create;

use PaylandsSDK\Requests\CreateCustomerAddressRequest;
use PaylandsSDK\Responses\CreateCustomerAddressResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\CustomerAddress;
use PaylandsSDK\Types\Enums\AddressType;
use PaylandsSDK\Utils\HttpResponse;

class CreateCustomerAddressTest extends TestBase
{
    /**
 * @return void
 */
    public function test_createCustomerAddressTest_ok()
    {
        $request = new CreateCustomerAddressRequest(
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
                "POST",
                "customer/address",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new CreateCustomerAddressResponse(
            "OK",
            200,
            "2019-11-19T16:47:48+0100",
            new Customer("12345678A"),
            new CustomerAddress(
                "B7B20B82-0112-464F-BE0F-2905BA84CDED",
                "Ronda",
                "Magdalena",
                "número 20",
                "Castellón",
                "Castellón",
                "ESP",
                "12006"
            )
        );
        $actual = $this->paylandsClient->createCustomerAddress($request);
        $this->assertEquals($expected, $actual);
    }
}
