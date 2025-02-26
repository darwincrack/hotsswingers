<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\ConfirmPaymentRequest;
use PHPUnit\Framework\TestCase;

class CreateConfirmPaymentRequestTest extends TestCase
{
    /**
 * @return void
 */
    public function test_constructor_with_all_args()
    {
        $order_uuid = "order uuid";
        $amount = 500;
        $request = new ConfirmPaymentRequest($order_uuid, $amount);
        $this->assertEquals($order_uuid, $request->getOrderUuid());
        $this->assertEquals($amount, $request->getAmount());
    }

    /**
 * @return void
 */
    public function test_optional_params_in_constructor()
    {
        $request = new ConfirmPaymentRequest("order uuid");
        $this->assertEquals("order uuid", $request->getOrderUuid());
        $this->assertNull($request->getAmount());
    }
}
