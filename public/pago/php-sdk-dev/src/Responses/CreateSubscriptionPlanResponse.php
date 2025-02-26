<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\SubscriptionPlan;

class CreateSubscriptionPlanResponse extends BaseResponse
{
    /**
     * @var SubscriptionPlan
     */
    private $plan;

    /**
     * CreateSubscriptionPlanResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param SubscriptionPlan $plan
     */
    public function __construct(string $message, int $code, string $current_time, SubscriptionPlan $plan)
    {
        parent::__construct($message, $code, $current_time);
        $this->plan = $plan;
    }

    /**
     * @return SubscriptionPlan
     */
    public function getPlan()
    {
        return $this->plan;
    }
}
