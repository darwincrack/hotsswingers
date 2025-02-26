<?php

namespace PaylandsSDK\Tests\Customer\Account\Remove;

use PaylandsSDK\Requests\RemoveCustomerAccountRequest;
use PaylandsSDK\Responses\RemoveCustomerAccountResponse;
use PaylandsSDK\Tests\TestBase;
use PaylandsSDK\Types\Account;
use PaylandsSDK\Types\Enums\AccountType;
use PaylandsSDK\Utils\HttpResponse;

class RemoveCustomerAccountTest extends TestBase
{
    /**
 * @return void
 */
    public function test_removeCustomerAccountTest_ok()
    {
        $request = new RemoveCustomerAccountRequest("123456");
        $this->httpClient->expects($this->once())
            ->method("request")
            ->with(
                "DELETE",
                "customer/account",
                ["json" => array_merge(["signature" => ""], $request->parseRequest())]
            )
            ->willReturn(new HttpResponse([], 200, $this->getExpectedResponse()));
        $expected = new RemoveCustomerAccountResponse(
            "OK",
            200,
            "2019-11-19T16:40:23+0100",
            new Account(
                "9B5DDCC2-24A9-4157-A56D-193EB9EF3966",
                AccountType::ACCOUNT_NUMBER(),
                "100169168"
            )
        );
        $actual = $this->paylandsClient->removeCustomerAccount($request);
        $this->assertEquals($expected, $actual);
    }
}
