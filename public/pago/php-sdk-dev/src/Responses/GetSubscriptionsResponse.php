<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Subscription;

/**
 * Class GetSubscriptionProductsResponse
 * @package PaylandsSDK\Responses
 */
class GetSubscriptionsResponse extends BaseResponse
{
    /**
     * @var Subscription[]
     */
    private $subscriptions = [];

    /**
     * GetSubscriptionsResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $subscriptions
     */
    public function __construct(string $message, int $code, string $current_time, array $subscriptions)
    {
        parent::__construct($message, $code, $current_time);
        $this->subscriptions = $subscriptions;
    }

    /**
     * @return array
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }
}
