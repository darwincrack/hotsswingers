<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\SubscriptionInterval;

/**
 * Class SubscriptionPlan
 */
class SubscriptionPlan
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
     * @var integer
     */
    private $amount;
    /**
     * @var integer
     */
    private $interval;
    /**
     * @var SubscriptionInterval
     */
    private $interval_type;
    /**
     * @var boolean
     */
    private $trial_available;
    /**
     * @var integer|null
     */
    private $interval_offset;
    /**
     * @var SubscriptionInterval|null
     */
    private $interval_offset_type;
    /**
     * @var string
     */
    private $created_at;
    /**
     * @var string
     */
    private $updated_at;
    /**
     * @var SubscriptionProduct
     */
    private $product;

    /**
     * SubscriptionPlan constructor.
     * @param string $name
     * @param string $external_id
     * @param int $amount
     * @param int $interval
     * @param SubscriptionInterval $interval_type
     * @param bool $trial_available
     * @param int $interval_offset
     * @param SubscriptionInterval $interval_offset_type
     * @param string $created_at
     * @param string $updated_at
     * @param SubscriptionProduct $product
     */
    public function __construct(
        string $name,
        string $external_id,
        int $amount,
        int $interval,
        SubscriptionInterval $interval_type,
        bool $trial_available,
        string $created_at,
        string $updated_at,
        SubscriptionProduct $product,
        int $interval_offset = null,
        SubscriptionInterval $interval_offset_type = null
    ) {
        $this->name = $name;
        $this->external_id = $external_id;
        $this->amount = $amount;
        $this->interval = $interval;
        $this->interval_type = $interval_type;
        $this->trial_available = $trial_available;
        $this->interval_offset = $interval_offset;
        $this->interval_offset_type = $interval_offset_type;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->product = $product;
    }

//    public static function createFromObject($object) {
//        $instance = parent::createFromObject($object);
//        $instance->product = SubscriptionProduct::createFromObject($object->product);
//        return $instance;
//    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SubscriptionPlan
     */
    public function setName(string $name): SubscriptionPlan
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
     * @return SubscriptionPlan
     */
    public function setExternalId(string $external_id): SubscriptionPlan
    {
        $this->external_id = $external_id;
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
     * @return SubscriptionPlan
     */
    public function setAmount(int $amount): SubscriptionPlan
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     * @return SubscriptionPlan
     */
    public function setInterval(int $interval): SubscriptionPlan
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
     * @return SubscriptionPlan
     */
    public function setIntervalType(SubscriptionInterval $interval_type): SubscriptionPlan
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
     * @return SubscriptionPlan
     */
    public function setTrialAvailable(bool $trial_available): SubscriptionPlan
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
     * @return SubscriptionPlan
     */
    public function setIntervalOffset(int $interval_offset): SubscriptionPlan
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
     * @return SubscriptionPlan
     */
    public function setIntervalOffsetType(SubscriptionInterval $interval_offset_type): SubscriptionPlan
    {
        $this->interval_offset_type = $interval_offset_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return SubscriptionPlan
     */
    public function setCreatedAt(string $created_at): SubscriptionPlan
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     * @return SubscriptionPlan
     */
    public function setUpdatedAt(string $updated_at): SubscriptionPlan
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return SubscriptionProduct
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param SubscriptionProduct $product
     * @return SubscriptionPlan
     */
    public function setProduct(SubscriptionProduct $product): SubscriptionPlan
    {
        $this->product = $product;
        return $this;
    }
}
