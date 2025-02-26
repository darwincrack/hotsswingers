<?php

namespace PaylandsSDK\Tests\Customer\CreateCustomer;

use PaylandsSDK\Requests\CreateCustomerRequest;
use PaylandsSDK\Responses\CreateCustomerResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Utils\HttpResponse;

class CreateCustomerTest extends TestBase
{
    /**
 * @return void
 */
    public function test_createCustomerTest_ok()
    {
        $request = new CreateCustomerRequest("customer1123");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "customer",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new CreateCustomerResponse(
            "OK",
            200,
            "2017-01-12T09:12:58+0100",
            new Customer(
                "customer15487",
                "55189www42efe21cc9ddad08bae7ae653b566a4142f0eb7c92487cab484fcfff249644f2f2f1b9f6b2e702a7e435e43c2c5d11f2fe68df014bd23d9e99a879afb"
            )
        );
        $actual = $this->paylandsClient->createCustomer($request);
        $this->assertEquals($expected, $actual);
    }
}
