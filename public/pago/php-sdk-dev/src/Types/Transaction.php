<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\Operative;
use PaylandsSDK\Types\Enums\TransactionStatus;

/**
 * Class Transaction
 */
class Transaction
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
     * @var Operative
     */
    private $operative;
    /**
     * @var integer
     */
    private $amount;
    /**
     * @var string
     */
    private $authorization;
    /**
     * @var string
     */
    private $error;
    /**
     * @var Card
     */
    private $source;
    /**
     * @var Antifraud|null
     */
    private $antifraud = null;
    /**
     * @var TransactionStatus
     */
    private $status;

    /**
     * Transaction constructor.
     * @param string $uuid
     * @param string $created
     * @param string $created_from_client_timezone
     * @param Operative $operative
     * @param int $amount
     * @param string $authorization
     * @param string $error
     * @param Card $source
     * @param TransactionStatus $status
     * @param Antifraud|null $antifraud
     */
    public function __construct(
        string $uuid,
        string $created,
        string $created_from_client_timezone,
        Operative $operative,
        int $amount,
        string $authorization,
        string $error,
        Card $source,
        TransactionStatus $status,
        Antifraud $antifraud = null
    ) {
        $this->uuid = $uuid;
        $this->created = $created;
        $this->created_from_client_timezone = $created_from_client_timezone;
        $this->operative = $operative;
        $this->amount = $amount;
        $this->authorization = $authorization;
        $this->error = $error;
        $this->source = $source;
        $this->antifraud = $antifraud;
        $this->status = $status;
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
     * @return Transaction
     */
    public function setUuid(string $uuid): Transaction
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
     * @return Transaction
     */
    public function setCreated(string $created): Transaction
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
     * @return Transaction
     */
    public function setCreatedFromClientTimezone(string $created_from_client_timezone): Transaction
    {
        $this->created_from_client_timezone = $created_from_client_timezone;
        return $this;
    }

    /**
     * @return Operative
     */
    public function getOperative()
    {
        return $this->operative;
    }

    /**
     * @param Operative $operative
     * @return Transaction
     */
    public function setOperative(Operative $operative): Transaction
    {
        $this->operative = $operative;
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
     * @return Transaction
     */
    public function setAmount(int $amount): Transaction
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param string $authorization
     * @return Transaction
     */
    public function setAuthorization(string $authorization): Transaction
    {
        $this->authorization = $authorization;
        return $this;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     * @return Transaction
     */
    public function setError(string $error): Transaction
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return Card
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param Card $source
     * @return Transaction
     */
    public function setSource(Card $source): Transaction
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return Antifraud|null
     */
    public function getAntifraud()
    {
        return $this->antifraud;
    }

    /**
     * @param Antifraud $antifraud
     * @return Transaction
     */
    public function setAntifraud(Antifraud $antifraud): Transaction
    {
        $this->antifraud = $antifraud;
        return $this;
    }

    /**
     * @return TransactionStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param TransactionStatus $status
     * @return Transaction
     */
    public function setStatus(TransactionStatus $status): Transaction
    {
        $this->status = $status;
        return $this;
    }
}
