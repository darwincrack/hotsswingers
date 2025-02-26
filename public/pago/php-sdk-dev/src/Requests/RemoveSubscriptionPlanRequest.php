<?php


namespace PaylandsSDK\Requests;

/**
 * Class RemoveSubscriptionPlanRequest
 * @package PaylandsSDK\Requests
 */
class RemoveSubscriptionPlanRequest
{
    /**
     * @var string
     */
    private $plan_external_id;

    /**
     * RemoveSubscriptionPlanRequest constructor.
     * @param string $plan_external_id
     */
    public function __construct(string $plan_external_id)
    {
        $this->plan_external_id = $plan_external_id;
    }

    /**
     * @return string
     */
    public function getPlanExternalId()
    {
        return $this->plan_external_id;
    }

    /**
     * @param string $plan_external_id
     * @return RemoveSubscriptionPlanRequest
     */
    public function setPlanExternalId(string $plan_external_id): RemoveSubscriptionPlanRequest
    {
        $this->plan_external_id = $plan_external_id;
        return $this;
    }
}
