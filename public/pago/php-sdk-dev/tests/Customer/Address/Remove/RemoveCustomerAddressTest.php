<?php

namespace PaylandsSDK\Tests\Customer\Address\Remove;

use PaylandsSDK\Requests\RemoveCustomerAddressRequest;
use PaylandsSDK\Responses\RemoveCustomerAddressResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\CustomerAddress;
use PaylandsSDK\Types\Enums\AddressType;
use PaylandsSDK\Utils\HttpResponse;

class RemoveCustomerAddressTest extends TestBase
{
    /**
 * @return void
 */
    public function test_removeCustomerAddressTest_ok()
    {
        $request = new RemoveCustomerAddressRequest("123456");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "DELETE",
                "customer/address",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new RemoveCustomerAddressResponse(
            "OK",
            200,
            "2019-11-19T17:04:32+0100",
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
        $actual = $this->paylandsClient->removeCustomerAddress($request);
        $this->assertEquals($expected, $actual);
    }
}
