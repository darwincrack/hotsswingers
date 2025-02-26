<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Requests\PaymentOrderExtraData;
use PaylandsSDK\Types\Client;
use PaylandsSDK\Types\Order;

class SendPayoutResponse extends BaseResponse
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var Client|null
     */
    private $client;

    /**
     * @var PaymentOrderExtraData|null
     */
    private $extra_data;

    /**
     * SendPayoutResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param Order $order
     * @param Client $client
     * @param PaymentOrderExtraData|null $extra_data
     */
    public function __construct(string $message, int $code, string $current_time, Order $order, Client $client, PaymentOrderExtraData $extra_data = null)
    {
        parent::__construct($message, $code, $current_time);
        $this->order = $order;
        $this->client = $client;
        $this->extra_data = $extra_data;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return Client|null
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return PaymentOrderExtraData|null
     */
    public function getExtraData()
    {
        return $this->extra_data;
    }
}
