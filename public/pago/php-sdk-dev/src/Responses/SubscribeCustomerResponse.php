<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Subscription;

class SubscribeCustomerResponse extends BaseResponse
{
    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * SubscribeCustomerResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param Subscription $subscription
     */
    public function __construct(string $message, int $code, string $current_time, Subscription $subscription)
    {
        parent::__construct($message, $code, $current_time);
        $this->subscription = $subscription;
    }

    /**
     * @return Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }
}
