<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\GeneratePaymentOrderRequest;
use PaylandsSDK\Requests\Payment;
use PaylandsSDK\Requests\PaymentOrderExtraData;
use PaylandsSDK\Types\Enums\Operative;
use PHPUnit\Framework\TestCase;

class GeneratePaymentOrderRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test__construct_with_all_args()
    {
        $extra_data = new PaymentOrderExtraData(new Payment(5));
        $request = new GeneratePaymentOrderRequest(
            500,
            Operative::AUTHORIZATION(),
            "customer id",
            "service",
            "description",
            "additional",
            true,
            "url post",
            "url ok",
            "url ko",
            "source uuid",
            "template uuid",
            "dcc template uuid",
            $extra_data
        );
        $this->assertEquals(500, $request->getAmount());
        $this->assertEquals(Operative::AUTHORIZATION(), $request->getOperative());
        $this->assertEquals("customer id", $request->getCustomerExtId());
        $this->assertEquals("service", $request->getService());
        $this->assertEquals("description", $request->getDescription());
        $this->assertEquals("additional", $request->getAdditional());
        $this->assertTrue($request->isSecure());
        $this->assertEquals("url post", $request->getUrlPost());
        $this->assertEquals("url ok", $request->getUrlOk());
        $this->assertEquals("url ko", $request->getUrlKo());
        $this->assertEquals("source uuid", $request->getSourceUuid());
        $this->assertEquals("template uuid", $request->getTemplateUuid());
        $this->assertEquals("dcc template uuid", $request->getDccTemplateUuid());
        $this->assertEquals($extra_data, $request->getExtraData());
    }

    /**
 * @return void
 */
    public function test__construct_without_all_args()
    {
        $request = new GeneratePaymentOrderRequest(
            500,
            Operative::AUTHORIZATION(),
            "customer id",
            "service",
            "description"
        );
        $this->assertEquals(500, $request->getAmount());
        $this->assertEquals(Operative::AUTHORIZATION(), $request->getOperative());
        $this->assertEquals("customer id", $request->getCustomerExtId());
        $this->assertEquals("service", $request->getService());
        $this->assertEquals("description", $request->getDescription());
        $this->assertNull($request->getAdditional());
        $this->assertFalse($request->isSecure());
        $this->assertNull($request->getUrlPost());
        $this->assertNull($request->getUrlOk());
        $this->assertNull($request->getUrlKo());
        $this->assertNull($request->getSourceUuid());
        $this->assertNull($request->getTemplateUuid());
        $this->assertNull($request->getDccTemplateUuid());
        $this->assertNull($request->getExtraData());
    }
}
