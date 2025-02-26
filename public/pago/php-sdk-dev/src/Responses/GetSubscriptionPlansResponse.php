<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\SubscriptionPlan;

/**
 * Class GetSubscriptionProductsResponse
 * @package PaylandsSDK\Responses
 */
class GetSubscriptionPlansResponse extends BaseResponse
{
    /**
     * @var SubscriptionPlan[]
     */
    private $plans = [];

    /**
     * GetSubscriptionPlansResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $plans
     */
    public function __construct(string $message, int $code, string $current_time, array $plans)
    {
        parent::__construct($message, $code, $current_time);
        $this->plans = $plans;
    }

    /**
     * @return array
     */
    public function getPlans()
    {
        return $this->plans;
    }
}
