<?php


namespace PaylandsSDK\Requests;

/**
 * Class ConfirmPaymentRequest
 * @package PaylandsSDK\Requests
 */
class ConfirmPaymentRequest
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
     * ConfirmPaymentRequest constructor.
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
            "amount" => $this->amount
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
     * @return ConfirmPaymentRequest
     */
    public function setOrderUuid(string $order_uuid): ConfirmPaymentRequest
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
     * @return ConfirmPaymentRequest
     */
    public function setAmount(float $amount): ConfirmPaymentRequest
    {
        $this->amount = $amount;
        return $this;
    }
}
