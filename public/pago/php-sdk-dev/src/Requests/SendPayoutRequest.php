<?php


namespace PaylandsSDK\Requests;

/**
 * Class SendPayoutRequest
 * @package PaylandsSDK\Requests
 */
class SendPayoutRequest
{
    /**
     * @var string
     */
    private $order_uuid;
    /**
     * @var string
     */
    private $source_uuid;

    /**
     * SendPayoutRequest constructor.
     * @param string $order_uuid
     * @param string $source_uuid
     */
    public function __construct(string $order_uuid, string $source_uuid)
    {
        $this->order_uuid = $order_uuid;
        $this->source_uuid = $source_uuid;
    }

    public function parseRequest(): array
    {
        return [
            "order_uuid" => $this->order_uuid,
            "source_uuid" => $this->source_uuid
        ];
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
     * @return SendPayoutRequest
     */
    public function setOrderUuid(string $order_uuid): SendPayoutRequest
    {
        $this->order_uuid = $order_uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceUuid()
    {
        return $this->source_uuid;
    }

    /**
     * @param string $source_uuid
     * @return SendPayoutRequest
     */
    public function setSourceUuid(string $source_uuid): SendPayoutRequest
    {
        $this->source_uuid = $source_uuid;
        return $this;
    }
}
