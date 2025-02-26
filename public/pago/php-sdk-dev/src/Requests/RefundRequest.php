<?php


namespace PaylandsSDK\Requests;

class RefundRequest
{
    /**
     * @var string
     */
    private $order_uuid;
    /**
     * @var float|null
     */
    private $amount;

    /**
     * RefundRequest constructor.
     * @param string $order_uuid
     * @param float|null $amount
     */
    public function __construct(string $order_uuid, float $amount = null)
    {
        $this->order_uuid = $order_uuid;
        $this->amount = $amount;
    }

    public function parseRequest(): array
    {
        return [
            "order_uuid" => $this->order_uuid,
            "amount" => $this->amount,
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
     * @return RefundRequest
     */
    public function setOrderUuid(string $order_uuid): RefundRequest
    {
        $this->order_uuid = $order_uuid;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return RefundRequest
     */
    public function setAmount(float $amount): RefundRequest
    {
        $this->amount = $amount;
        return $this;
    }
}
