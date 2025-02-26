<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\SaveCardRequest;
use PHPUnit\Framework\TestCase;

class SaveCardRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new SaveCardRequest(
            "customer_ext_id",
            "card_holder",
            "card_pan",
            "20",
            "12",
            "123",
            true,
            "service",
            "additional",
            "url_post"
        );
        $this->assertEquals("customer_ext_id", $request->getCustomerExtId());
        $this->assertEquals("card_holder", $request->getCardHolder());
        $this->assertEquals("card_pan", $request->getCardPan());
        $this->assertEquals("20", $request->getCardExpiryYear());
        $this->assertEquals("12", $request->getCardExpiryMonth());
        $this->assertTrue($request->isValidate());
        $this->assertEquals("service", $request->getService());
        $this->assertEquals("additional", $request->getAdditional());
        $this->assertEquals("url_post", $request->getUrlPost());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new SaveCardRequest(
            "customer_ext_id",
            "card_holder",
            "card_pan",
            "20",
            "12",
            "123",
            true,
            "service"
        );
        $this->assertEquals("customer_ext_id", $request->getCustomerExtId());
        $this->assertEquals("card_holder", $request->getCardHolder());
        $this->assertEquals("card_pan", $request->getCardPan());
        $this->assertEquals("20", $request->getCardExpiryYear());
        $this->assertEquals("12", $request->getCardExpiryMonth());
        $this->assertTrue($request->isValidate());
        $this->assertEquals("service", $request->getService());
        $this->assertNull($request->getAdditional());
        $this->assertNull($request->getUrlPost());
    }
}
