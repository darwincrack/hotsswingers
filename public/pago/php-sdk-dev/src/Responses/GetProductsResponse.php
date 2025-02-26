<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Product;

/**
 * Class GetProductsResponse
 * @package PaylandsSDK\Responses
 */
class GetProductsResponse extends BaseResponse
{
    /**
     * @var Product[]
     */
    private $products;

    /**
     * GetProductsResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $products
     */
    public function __construct(string $message, int $code, string $current_time, array $products)
    {
        parent::__construct($message, $code, $current_time);
        $this->products = $products;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }
}
