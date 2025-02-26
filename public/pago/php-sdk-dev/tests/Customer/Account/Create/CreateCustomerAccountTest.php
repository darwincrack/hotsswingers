<?php

namespace PaylandsSDK\Tests\Customer\Account\Create;

use PaylandsSDK\Requests\CreateCustomerAccountRequest;
use PaylandsSDK\Responses\CreateCustomerAccountResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Account;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\Enums\AccountType;
use PaylandsSDK\Utils\HttpResponse;

class CreateCustomerAccountTest extends TestBase
{
    /**
 * @return void
 */
    public function test_createCustomerAccountTest_ok()
    {
        $request = new CreateCustomerAccountRequest(
            "123456",
            AccountType::PERSONAL(),
            "100169168"
        );
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "POST",
                "customer/account",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new CreateCustomerAccountResponse(
            "OK",
            200,
            "2019-11-19T15:57:46+0100",
            new Customer("12345678A"),
            new Account(
                "9B5DDCC2-24A9-4157-A56D-193EB9EF3966",
                AccountType::ACCOUNT_NUMBER(),
                "100169168"
            )
        );
        $actual = $this->paylandsClient->createCustomerAccount($request);
        $this->assertEquals($expected, $actual);
    }
}
