<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\SendOneStepPaymentRequest;
use PaylandsSDK\Types\Enums\Operative;
use PHPUnit\Framework\TestCase;

class SendOneStepPaymentRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $request = new SendOneStepPaymentRequest(
            123,
            Operative::AUTHORIZATION(),
            "customer_ext_id",
            "additional",
            "service",
            true,
            "description",
            "card_holder",
            "card_pan",
            "20",
            "12",
            "url_post",
            "url_ok",
            "url_ko",
            "template_uuid",
            "card_additional",
            "card_cvv",
            "customer_ip"
        );
        $this->assertEquals(123, $request->getAmount());
        $this->assertEquals(Operative::AUTHORIZATION(), $request->getOperative());
        $this->assertEquals("customer_ext_id", $request->getCustomerExtId());
        $this->assertEquals("additional", $request->getAdditional());
        $this->assertEquals("service", $request->getService());
        $this->assertTrue($request->isSecure());
        $this->assertEquals("description", $request->getDescription());
        $this->assertEquals("card_holder", $request->getCardHolder());
        $this->assertEquals("card_pan", $request->getCardPan());
        $this->assertEquals("20", $request->getCardExpiryYear());
        $this->assertEquals("12", $request->getCardExpiryMonth());
        $this->assertEquals("url_post", $request->getUrlPost());
        $this->assertEquals("url_ok", $request->getUrlOk());
        $this->assertEquals("url_ko", $request->getUrlKo());
        $this->assertEquals("template_uuid", $request->getTemplateUuid());
        $this->assertEquals("card_additional", $request->getCardAdditional());
        $this->assertEquals("card_cvv", $request->getCardCvv());
        $this->assertEquals("customer_ip", $request->getCustomerIp());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new SendOneStepPaymentRequest(
            123,
            Operative::AUTHORIZATION(),
            "customer_ext_id",
            "additional",
            "service",
            true,
            "description",
            "card_holder",
            "card_pan",
            "20",
            "12"
        );
        $this->assertEquals(123, $request->getAmount());
        $this->assertEquals(Operative::AUTHORIZATION(), $request->getOperative());
        $this->assertEquals("customer_ext_id", $request->getCustomerExtId());
        $this->assertEquals("additional", $request->getAdditional());
        $this->assertEquals("service", $request->getService());
        $this->assertTrue($request->isSecure());
        $this->assertEquals("description", $request->getDescription());
        $this->assertEquals("card_holder", $request->getCardHolder());
        $this->assertEquals("card_pan", $request->getCardPan());
        $this->assertEquals("20", $request->getCardExpiryYear());
        $this->assertEquals("12", $request->getCardExpiryMonth());
        $this->assertNull($request->getUrlPost());
        $this->assertNull($request->getUrlOk());
        $this->assertNull($request->getUrlKo());
        $this->assertNull($request->getTemplateUuid());
        $this->assertNull($request->getCardAdditional());
        $this->assertNull($request->getCardCvv());
        $this->assertNull($request->getCustomerIp());
    }
}
