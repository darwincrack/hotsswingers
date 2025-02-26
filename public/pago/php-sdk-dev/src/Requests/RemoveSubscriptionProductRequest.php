<?php


namespace PaylandsSDK\Requests;

/**
 * Class RemoveSubscriptionProductRequest
 * @package PaylandsSDK\Requests
 */
class RemoveSubscriptionProductRequest
{
    /**
     * @var string
     */
    private $product_external_id;

    /**
     * RemoveSubscriptionProductRequest constructor.
     * @param string $product_external_id
     */
    public function __construct(string $product_external_id)
    {
        $this->product_external_id = $product_external_id;
    }

    /**
     * @return string
     */
    public function getProductExternalId()
    {
        return $this->product_external_id;
    }

    /**
     * @param string $product_external_id
     * @return RemoveSubscriptionProductRequest
     */
    public function setProductExternalId(string $product_external_id): RemoveSubscriptionProductRequest
    {
        $this->product_external_id = $product_external_id;
        return $this;
    }
}
