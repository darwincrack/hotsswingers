<?php

namespace PaylandsSDK\Tests\Requests;

use PaylandsSDK\Requests\CustomerCardRequest;
use PaylandsSDK\Requests\SaveCardsRequest;
use PHPUnit\Framework\TestCase;

class SaveCardsRequestTest extends TestCase {
    private $customerCardRequest;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->customerCardRequest = new CustomerCardRequest(
            "customer id",
            "card hoder",
            "card pan",
            "20",
            "12",
            "123"
        );
    }


    /**
     * @return void
     */
    public function test__construct_with_all_args() {
        $request = new SaveCardsRequest([$this->customerCardRequest]);
        $this->assertNotEmpty($request->getCards());
    }

    /**
     * @return void
     */
    public function test__construct_without_args() {
        $request = new SaveCardsRequest();
        $this->assertEmpty($request->getCards());
    }

    /**
     * @return void
     */
    public function test_add_card_to_request() {
        $request = new SaveCardsRequest();
        $request->addCard($this->customerCardRequest);
        $this->assertSameSize([1], $request->getCards());
        $this->assertEquals($this->customerCardRequest, $request->getCards()[0]);
    }
}
