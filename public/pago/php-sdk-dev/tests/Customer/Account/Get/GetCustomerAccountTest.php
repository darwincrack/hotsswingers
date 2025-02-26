<?php

namespace PaylandsSDK\Tests\Customer\Account\Get;

use PaylandsSDK\Requests\GetCustomerAccountRequest;
use PaylandsSDK\Responses\GetCustomerAccountResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Account;
use PaylandsSDK\Types\Enums\AccountType;
use PaylandsSDK\Utils\HttpResponse;

class GetCustomerAccountTest extends TestBase
{
    /**
 * @return void
 */
    public function test_getCustomerAccountTest_ok()
    {
        $request = new GetCustomerAccountRequest("123456");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "GET",
                "customer/account/" . $request->getUuid()
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new GetCustomerAccountResponse(
            "OK",
            200,
            "2019-11-19T16:24:21+0100",
            new Account(
                "9B5DDCC2-24A9-4157-A56D-193EB9EF3966",
                AccountType::ACCOUNT_NUMBER(),
                "100169168"
            )
        );
        $actual = $this->paylandsClient->getCustomerAccount($request);
        $this->assertEquals($expected, $actual);
    }
}
