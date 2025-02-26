<?php


namespace PaylandsSDK\Requests;

/**
 * Class CancelPaymentRequest
 * @package PaylandsSDK\Requests
 */
class CancelPaymentRequest
{
    /**
     * @var String order_uuid
     */
    private $order_uuid;

    /**
     * CancelPaymentRequest constructor.
     * @param string $order_uuid
     */
    public function __construct(string $order_uuid)
    {
        $this->order_uuid = $order_uuid;
    }

    public function parseRequest(): array
    {
        return [
            "order_uuid" => $this->order_uuid
        ];
    }

    /**
     * @return String
     */
    public function getOrderUuid()
    {
        return $this->order_uuid;
    }

    /**
     * @param String $order_uuid
     * @return CancelPaymentRequest
     */
    public function setOrderUuid(String $order_uuid): CancelPaymentRequest
    {
        $this->order_uuid = $order_uuid;
        return $this;
    }
}
