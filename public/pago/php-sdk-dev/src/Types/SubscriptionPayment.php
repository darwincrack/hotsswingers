<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\SubscriptionPaymentStatus;

/**
 * Class SubscriptionPayment
 * @package PaylandsSDK\Types
 */
class SubscriptionPayment
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var SubscriptionPaymentStatus
     */
    private $status;
    /**
     * @var string
     */
    private $payment_date;
    /**
     * @var int
     */
    private $payment_number;
    /**
     * @var int
     */
    private $attempt;
    /**
     * @var int
     */
    private $amount;
    /**
     * @var string|null
     */
    private $payment_details;
    /**
     * @var string
     */
    private $created_at;
    /**
     * @var string
     */
    private $updated_at;

    /**
     * SubscriptionPayment constructor.
     * @param string $id
     * @param SubscriptionPaymentStatus $status
     * @param string $payment_date
     * @param int $payment_number
     * @param int $attempt
     * @param int $amount
     * @param string $created_at
     * @param string $updated_at
     * @param string $payment_details
     */
    public function __construct(string $id, SubscriptionPaymentStatus $status, string $payment_date, int $payment_number, int $attempt, int $amount, string $created_at, string $updated_at, string $payment_details = null)
    {
        $this->id = $id;
        $this->status = $status;
        $this->payment_date = $payment_date;
        $this->payment_number = $payment_number;
        $this->attempt = $attempt;
        $this->amount = $amount;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->payment_details = $payment_details;
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
     * @return SubscriptionPayment
     */
    public function setId(string $id): SubscriptionPayment
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return SubscriptionPaymentStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param SubscriptionPaymentStatus $status
     * @return SubscriptionPayment
     */
    public function setStatus(SubscriptionPaymentStatus $status): SubscriptionPayment
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentDate()
    {
        return $this->payment_date;
    }

    /**
     * @param string $payment_date
     * @return SubscriptionPayment
     */
    public function setPaymentDate(string $payment_date): SubscriptionPayment
    {
        $this->payment_date = $payment_date;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentNumber()
    {
        return $this->payment_number;
    }

    /**
     * @param int $payment_number
     * @return SubscriptionPayment
     */
    public function setPaymentNumber(int $payment_number): SubscriptionPayment
    {
        $this->payment_number = $payment_number;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttempt()
    {
        return $this->attempt;
    }

    /**
     * @param int $attempt
     * @return SubscriptionPayment
     */
    public function setAttempt(int $attempt): SubscriptionPayment
    {
        $this->attempt = $attempt;
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
     * @return SubscriptionPayment
     */
    public function setAmount(int $amount): SubscriptionPayment
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentDetails()
    {
        return $this->payment_details;
    }

    /**
     * @param string $payment_details
     * @return SubscriptionPayment
     */
    public function setPaymentDetails(string $payment_details): SubscriptionPayment
    {
        $this->payment_details = $payment_details;
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
     * @return SubscriptionPayment
     */
    public function setCreatedAt(string $created_at): SubscriptionPayment
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
     * @return SubscriptionPayment
     */
    public function setUpdatedAt(string $updated_at): SubscriptionPayment
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}
