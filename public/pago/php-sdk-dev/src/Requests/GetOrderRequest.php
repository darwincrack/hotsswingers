<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetOrderRequest
 * @package PaylandsSDK\Requests
 */
class GetOrderRequest
{

    /**
     * @var string
     */
    private $order_uuid;

    /**
     * GetOrdersRequest constructor.
     * @param string $order_uuid
     */
    public function __construct(string $order_uuid)
    {
        $this->order_uuid = $order_uuid;
    }

    /**
     * @return string
     */
    public function getOrderUuid()
    {
        return $this->order_uuid;
    }

    /**
     * @param string $order_uuid
     * @return GetOrderRequest
     */
    public function setOrderUuid(string $order_uuid): GetOrderRequest
    {
        $this->order_uuid = $order_uuid;
        return $this;
    }
}
