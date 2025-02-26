<?php

namespace PaylandsSDK\Tests\Customer\Account\Update;

use PaylandsSDK\Requests\UpdateCustomerAccountRequest;
use PaylandsSDK\Responses\UpdateCustomerAccountResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Account;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\Enums\AccountType;
use PaylandsSDK\Utils\HttpResponse;

class UpdateCustomerAccountTest extends TestBase
{
    /**
 * @return void
 */
    public function test_updateCustomerAccountTest_ok()
    {
        $request = new UpdateCustomerAccountRequest(
            "123456",
            "123456",
            AccountType::PERSONAL(),
            "100169168"
        );
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "PUT",
                "customer/account",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new UpdateCustomerAccountResponse(
            "OK",
            200,
            "2019-11-19T16:00:36+0100",
            new Customer("12345678A"),
            new Account(
                "9B5DDCC2-24A9-4157-A56D-193EB9EF3966",
                AccountType::ACCOUNT_NUMBER(),
                "100169168"
            )
        );
        $actual = $this->paylandsClient->updateCustomerAccount($request);
        $this->assertEquals($expected, $actual);
    }
}
