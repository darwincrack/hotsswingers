<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\SubscriptionProduct;

class CreateSubscriptionProductResponse extends BaseResponse
{
    /**
     * @var SubscriptionProduct
     */
    private $product;

    /**
     * CreateSubscriptionProductResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param SubscriptionProduct $product
     */
    public function __construct(string $message, int $code, string $current_time, SubscriptionProduct $product)
    {
        parent::__construct($message, $code, $current_time);
        $this->product = $product;
    }

    /**
     * @return SubscriptionProduct
     */
    public function getProduct()
    {
        return $this->product;
    }
}
