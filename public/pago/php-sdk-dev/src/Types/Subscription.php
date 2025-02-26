<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\SubscriptionStatus;

/**
 * Class Subscription
 */
class Subscription
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var boolean
     */
    private $active;
    /**
     * @var SubscriptionStatus
     */
    private $status;
    /**
     * @var integer
     */
    private $total_payment_number;
    /**
     * @var integer
     */
    private $total_payment_charged;
    /**
     * @var integer
     */
    private $payment_attempts_limit;
    /**
     * @var string
     */
    private $first_charge_date;
    /**
     * @var string
     */
    private $next_charge_date;
    /**
     * @var string
     */
    private $additional_data;
    /**
     * @var string
     */
    private $created_at;
    /**
     * @var string
     */
    private $updated_at;
    /**
     * @var SubscriptionPlan|null
     */
    private $plan;

    /**
     * @var array|null
     */
    private $payments;

    /**
     * Subscription constructor.
     * @param string $id
     * @param bool $active
     * @param SubscriptionStatus $status
     * @param int $total_payment_number
     * @param int $total_payment_charged
     * @param int $payment_attempts_limit
     * @param string $first_charge_date
     * @param string $next_charge_date
     * @param string $additional_data
     * @param string $created_at
     * @param string $updated_at
     * @param SubscriptionPlan|null $plan
     * @param array|null $payments
     */
    public function __construct(string $id, bool $active, SubscriptionStatus $status, int $total_payment_number, int $total_payment_charged, int $payment_attempts_limit, string $first_charge_date, string $next_charge_date, string $additional_data, string $created_at, string $updated_at, SubscriptionPlan $plan = null, array $payments = null)
    {
        $this->id = $id;
        $this->active = $active;
        $this->status = $status;
        $this->total_payment_number = $total_payment_number;
        $this->total_payment_charged = $total_payment_charged;
        $this->payment_attempts_limit = $payment_attempts_limit;
        $this->first_charge_date = $first_charge_date;
        $this->next_charge_date = $next_charge_date;
        $this->additional_data = $additional_data;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->plan = $plan;
        $this->payments = $payments;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Subscription
     */
    public function setId(string $id): Subscription
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Subscription
     */
    public function setActive(bool $active): Subscription
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return SubscriptionStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param SubscriptionStatus $status
     * @return Subscription
     */
    public function setStatus(SubscriptionStatus $status): Subscription
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPaymentNumber()
    {
        return $this->total_payment_number;
    }

    /**
     * @param int $total_payment_number
     * @return Subscription
     */
    public function setTotalPaymentNumber(int $total_payment_number): Subscription
    {
        $this->total_payment_number = $total_payment_number;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPaymentCharged()
    {
        return $this->total_payment_charged;
    }

    /**
     * @param int $total_payment_charged
     * @return Subscription
     */
    public function setTotalPaymentCharged(int $total_payment_charged): Subscription
    {
        $this->total_payment_charged = $total_payment_charged;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentAttemptsLimit()
    {
        return $this->payment_attempts_limit;
    }

    /**
     * @param int $payment_attempts_limit
     * @return Subscription
     */
    public function setPaymentAttemptsLimit(int $payment_attempts_limit): Subscription
    {
        $this->payment_attempts_limit = $payment_attempts_limit;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstChargeDate()
    {
        return $this->first_charge_date;
    }

    /**
     * @param string $first_charge_date
     * @return Subscription
     */
    public function setFirstChargeDate(string $first_charge_date): Subscription
    {
        $this->first_charge_date = $first_charge_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getNextChargeDate()
    {
        return $this->next_charge_date;
    }

    /**
     * @param string $next_charge_date
     * @return Subscription
     */
    public function setNextChargeDate(string $next_charge_date): Subscription
    {
        $this->next_charge_date = $next_charge_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalData()
    {
        return $this->additional_data;
    }

    /**
     * @param string $additional_data
     * @return Subscription
     */
    public function setAdditionalData(string $additional_data): Subscription
    {
        $this->additional_data = $additional_data;
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
     * @return Subscription
     */
    public function setCreatedAt(string $created_at): Subscription
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
     * @return Subscription
     */
    public function setUpdatedAt(string $updated_at): Subscription
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return SubscriptionPlan|null
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param SubscriptionPlan $plan
     * @return Subscription
     */
    public function setPlan(SubscriptionPlan $plan): Subscription
    {
        $this->plan = $plan;
        return $this;
    }

    /**
     * @return array
     */
    public function getPayments()
    {
        return $this->payments ?? [];
    }

    /**
     * @param array $payments
     * @return Subscription
     */
    public function setPayments(array $payments): Subscription
    {
        $this->payments = $payments;
        return $this;
    }
}
