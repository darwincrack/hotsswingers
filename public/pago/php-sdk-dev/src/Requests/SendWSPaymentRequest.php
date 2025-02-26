<?php


namespace PaylandsSDK\Requests;

class SendWSPaymentRequest
{
    /**
     * @var string
     */
    private $customer_ip;
    /**
     * @var string
     */
    private $order_uuid;
    /**
     * @var string
     */
    private $card_uuid;

    /**
     * SendWSPaymentRequest constructor.
     * @param string $customer_ip
     * @param string $order_uuid
     * @param string $card_uuid
     */
    public function __construct(string $customer_ip, string $order_uuid, string $card_uuid)
    {
        $this->customer_ip = $customer_ip;
        $this->order_uuid = $order_uuid;
        $this->card_uuid = $card_uuid;
    }

    public function parseRequest(): array
    {
        return [
            "customer_ip" => $this->customer_ip,
            "order_uuid" => $this->order_uuid,
            "card_uuid" => $this->card_uuid
        ];
    }


    /**
     * @return mixed
     */
    public function getCustomerIp()
    {
        return $this->customer_ip;
    }

    /**
     * @param mixed $customer_ip
     * @return SendWSPaymentRequest
     */
    public function setCustomerIp($customer_ip)
    {
        $this->customer_ip = $customer_ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderUuid()
    {
        return $this->order_uuid;
    }

    /**
     * @param mixed $order_uuid
     * @return SendWSPaymentRequest
     */
    public function setOrderUuid($order_uuid)
    {
        $this->order_uuid = $order_uuid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardUuid()
    {
        return $this->card_uuid;
    }

    /**
     * @param mixed $card_uuid
     * @return SendWSPaymentRequest
     */
    public function setCardUuid($card_uuid)
    {
        $this->card_uuid = $card_uuid;
        return $this;
    }
}
