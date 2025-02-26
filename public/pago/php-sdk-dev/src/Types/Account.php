<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\AccountType;

/**
 * Class Account
 */
class Account
{
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var AccountType
     */
    private $account_type;
    /**
     * @var string
     */
    private $account_number;

    /**
     * Account constructor.
     * @param string $uuid
     * @param AccountType $account_type
     * @param string $account_number
     */
    public function __construct(string $uuid, AccountType $account_type, string $account_number)
    {
        $this->uuid = $uuid;
        $this->account_type = $account_type;
        $this->account_number = $account_number;
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
     * @return Account
     */
    public function setUuid(string $uuid): Account
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return AccountType
     */
    public function getAccountType()
    {
        return $this->account_type;
    }

    /**
     * @param AccountType $account_type
     * @return Account
     */
    public function setAccountType(AccountType $account_type): Account
    {
        $this->account_type = $account_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    /**
     * @param string $account_number
     * @return Account
     */
    public function setAccountNumber(string $account_number): Account
    {
        $this->account_number = $account_number;
        return $this;
    }
}
