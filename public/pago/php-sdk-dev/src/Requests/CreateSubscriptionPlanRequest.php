<?php


namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\SubscriptionInterval;

/**
 * Class CreateSubscriptionPlanRequest
 * @package PaylandsSDK\Requests
 */
class CreateSubscriptionPlanRequest
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $external_id;
    /**
     * @var string
     */
    private $product;
    /**
     * @var int
     */
    private $amount;
    /**
     * @var int
     */
    private $interval;
    /**
     * @var SubscriptionInterval
     */
    private $interval_type;
    /**
     * @var boolean
     */
    private $trial_available = false;
    /**
     * @var int|null
     */
    private $interval_offset = null;
    /**
     * @var SubscriptionInterval|null
     */
    private $interval_offset_type = null;

    /**
     * CreateSubscriptionPlanRequest constructor.
     * @param string $name
     * @param string $external_id
     * @param string $product
     * @param int $amount
     * @param int $interval
     * @param SubscriptionInterval $interval_type
     * @param bool $trial_available
     * @param int $interval_offset
     * @param SubscriptionInterval $interval_offset_type
     */
    public function __construct(
        string $name,
        string $external_id,
        string $product,
        int $amount,
        int $interval,
        SubscriptionInterval $interval_type,
        $trial_available = false,
        $interval_offset = null,
        SubscriptionInterval $interval_offset_type = null
    ) {
        $this->name = $name;
        $this->external_id = $external_id;
        $this->product = $product;
        $this->amount = $amount;
        $this->interval = $interval;
        $this->interval_type = $interval_type;
        $this->trial_available = $trial_available;
        $this->interval_offset = $interval_offset;
        $this->interval_offset_type = $interval_offset_type;
    }

    public function parseRequest(): array
    {
        return [
            "name" => $this->name,
            "external_id" => $this->external_id,
            "product" => $this->product,
            "amount" => $this->amount,
            "interval" => $this->interval,
            "interval_type" => $this->interval_type,
            "trial_available" => $this->trial_available,
            "interval_offset" => $this->interval_offset,
            "interval_offset_type" => $this->interval_offset_type,
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CreateSubscriptionPlanRequest
     */
    public function setName(string $name): CreateSubscriptionPlanRequest
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * @param string $external_id
     * @return CreateSubscriptionPlanRequest
     */
    public function setExternalId(string $external_id): CreateSubscriptionPlanRequest
    {
        $this->external_id = $external_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param string $product
     * @return CreateSubscriptionPlanRequest
     */
    public function setProduct(string $product): CreateSubscriptionPlanRequest
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return CreateSubscriptionPlanRequest
     */
    public function setAmount(int $amount): CreateSubscriptionPlanRequest
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     * @return CreateSubscriptionPlanRequest
     */
    public function setInterval(int $interval): CreateSubscriptionPlanRequest
    {
        $this->interval = $interval;
        return $this;
    }

    /**
     * @return SubscriptionInterval
     */
    public function getIntervalType()
    {
        return $this->interval_type;
    }

    /**
     * @param SubscriptionInterval $interval_type
     * @return CreateSubscriptionPlanRequest
     */
    public function setIntervalType(SubscriptionInterval $interval_type): CreateSubscriptionPlanRequest
    {
        $this->interval_type = $interval_type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTrialAvailable()
    {
        return $this->trial_available;
    }

    /**
     * @param bool $trial_available
     * @return CreateSubscriptionPlanRequest
     */
    public function setTrialAvailable(bool $trial_available): CreateSubscriptionPlanRequest
    {
        $this->trial_available = $trial_available;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIntervalOffset()
    {
        return $this->interval_offset;
    }

    /**
     * @param int $interval_offset
     * @return CreateSubscriptionPlanRequest
     */
    public function setIntervalOffset(int $interval_offset): CreateSubscriptionPlanRequest
    {
        $this->interval_offset = $interval_offset;
        return $this;
    }

    /**
     * @return SubscriptionInterval|null
     */
    public function getIntervalOffsetType()
    {
        return $this->interval_offset_type;
    }

    /**
     * @param SubscriptionInterval $interval_offset_type
     * @return CreateSubscriptionPlanRequest
     */
    public function setIntervalOffsetType(SubscriptionInterval $interval_offset_type): CreateSubscriptionPlanRequest
    {
        $this->interval_offset_type = $interval_offset_type;
        return $this;
    }
}
