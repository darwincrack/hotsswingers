<?php


namespace PaylandsSDK\Requests;

class RemoveSubscriptionRequest
{
    /**
     * @var string
     */
    private $subscription_id;

    /**
     * RemoveSubscriptionRequest constructor.
     * @param string $subscription_id
     */
    public function __construct(string $subscription_id)
    {
        $this->subscription_id = $subscription_id;
    }

    /**
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscription_id;
    }

    /**
     * @param string $subscription_id
     * @return RemoveSubscriptionRequest
     */
    public function setSubscriptionId(string $subscription_id): RemoveSubscriptionRequest
    {
        $this->subscription_id = $subscription_id;
        return $this;
    }
}
