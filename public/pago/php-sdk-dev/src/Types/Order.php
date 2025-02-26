<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\OrderStatus;

/**
 * Class Order
 */
class Order
{
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var string
     */
    private $created;
    /**
     * @var string
     */
    private $created_from_client_timezone;
    /**
     * @var integer
     */
    private $amount;
    /**
     * @var string
     */
    private $currency;
    /**
     * @var boolean
     */
    private $paid;
    /**
     * @var boolean
     */
    private $safe;
    /**
     * @var integer
     */
    private $refunded;
    /**
     * @var string|null
     */
    private $additional;
    /**
     * @var string
     */
    private $service;

    /**
     * @var string|null
     */
    private $customer;
    /**
     * @var OrderStatus
     */
    private $status;
    /**
     * @var array
     */
    private $transactions = [];
    /**
     * @var string
     */
    private $token;
    /**
     * @var string|null
     */
    private $ip;

    /**
     * Order constructor.
     * @param string $uuid
     * @param string $created
     * @param string $created_from_client_timezone
     * @param int $amount
     * @param string $currency
     * @param bool $paid
     * @param bool $safe
     * @param int $refunded
     * @param string $service
     * @param OrderStatus $status
     * @param array $transactions
     * @param string $token
     * @param string|null $ip
     * @param string|null $customer
     * @param string|null $additional
     */
    public function __construct(
        string $uuid,
        string $created,
        string $created_from_client_timezone,
        int $amount,
        string $currency,
        bool $paid,
        bool $safe,
        int $refunded,
        string $service,
        OrderStatus $status,
        array $transactions,
        string $token,
        string $ip = null,
        string $customer = null,
        string $additional = null
    ) {
        $this->uuid = $uuid;
        $this->created = $created;
        $this->created_from_client_timezone = $created_from_client_timezone;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->paid = $paid;
        $this->safe = $safe;
        $this->refunded = $refunded;
        $this->additional = $additional;
        $this->service = $service;
        $this->customer = $customer;
        $this->status = $status;
        $this->transactions = $transactions;
        $this->token = $token;
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return Order
     */
    public function setUuid(string $uuid): Order
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $created
     * @return Order
     */
    public function setCreated(string $created): Order
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedFromClientTimezone()
    {
        return $this->created_from_client_timezone;
    }

    /**
     * @param string $created_from_client_timezone
     * @return Order
     */
    public function setCreatedFromClientTimezone(string $created_from_client_timezone): Order
    {
        $this->created_from_client_timezone = $created_from_client_timezone;
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
     * @return Order
     */
    public function setAmount(int $amount): Order
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Order
     */
    public function setCurrency(string $currency): Order
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @param bool $paid
     * @return Order
     */
    public function setPaid(bool $paid): Order
    {
        $this->paid = $paid;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSafe()
    {
        return $this->safe;
    }

    /**
     * @param bool $safe
     * @return Order
     */
    public function setSafe(bool $safe): Order
    {
        $this->safe = $safe;
        return $this;
    }

    /**
     * @return int
     */
    public function getRefunded()
    {
        return $this->refunded;
    }

    /**
     * @param int $refunded
     * @return Order
     */
    public function setRefunded(int $refunded): Order
    {
        $this->refunded = $refunded;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * @param string $additional
     * @return Order
     */
    public function setAdditional(string $additional): Order
    {
        $this->additional = $additional;
        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return Order
     */
    public function setService(string $service): Order
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     * @return Order
     */
    public function setCustomer(string $customer): Order
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return OrderStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param OrderStatus $status
     * @return Order
     */
    public function setStatus(OrderStatus $status): Order
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return array
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param array $transactions
     * @return Order
     */
    public function setTransactions(array $transactions): Order
    {
        $this->transactions = $transactions;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Order
     */
    public function setToken(string $token): Order
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return Order
     */
    public function setIp(string $ip): Order
    {
        $this->ip = $ip;
        return $this;
    }
}
