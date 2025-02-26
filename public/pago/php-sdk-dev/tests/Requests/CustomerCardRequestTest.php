<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\CustomerCardRequest;
use PHPUnit\Framework\TestCase;

class CustomerCardRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new CustomerCardRequest(
            "customer id",
            "card holder",
            "card pan",
            "2020",
            "12",
            "123",
            "url post",
            "additional"
        );
        $this->assertEquals("customer id", $request->getCustomerExtId());
        $this->assertEquals("card holder", $request->getCardHolder());
        $this->assertEquals("card pan", $request->getCardPan());
        $this->assertEquals("2020", $request->getCardExpiryYear());
        $this->assertEquals("12", $request->getCardExpiryMonth());
        $this->assertEquals("123", $request->getCardCvv());
        $this->assertEquals("url post", $request->getUrlPost());
        $this->assertEquals("additional", $request->getAdditional());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new CustomerCardRequest(
            "customer id",
            "card holder",
            "card pan",
            "2020",
            "12",
            "123"
        );
        $this->assertEquals("customer id", $request->getCustomerExtId());
        $this->assertEquals("card holder", $request->getCardHolder());
        $this->assertEquals("card pan", $request->getCardPan());
        $this->assertEquals("2020", $request->getCardExpiryYear());
        $this->assertEquals("12", $request->getCardExpiryMonth());
        $this->assertEquals("123", $request->getCardCvv());
        $this->assertNull($request->getUrlPost());
        $this->assertNull($request->getAdditional());
    }
}
