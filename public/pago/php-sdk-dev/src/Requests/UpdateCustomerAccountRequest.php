<?php


namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\AccountType;

/**
 * Class UpdateCustomerAccountRequest
 * @package PaylandsSDK\Requests
 */
class UpdateCustomerAccountRequest
{
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var string
     */
    private $external_id;
    /**
     * @var AccountType
     */
    private $account_type;
    /**
     * @var string
     */
    private $account_number;

    /**
     * CreateCustomerAccountRequest constructor.
     * @param string $uuid
     * @param string $external_id
     * @param AccountType $account_type
     * @param string $account_number
     */
    public function __construct(string $uuid, string $external_id, AccountType $account_type, string $account_number)
    {
        $this->uuid = $uuid;
        $this->external_id = $external_id;
        $this->account_type = $account_type;
        $this->account_number = $account_number;
    }

    public function parseRequest(): array
    {
        return [
            "uuid" => $this->uuid,
            "external_id" => $this->external_id,
            "account_type" => $this->account_type->getValue(),
            "account_number" => $this->account_number,
        ];
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
     * @return UpdateCustomerAccountRequest
     */
    public function setUuid(string $uuid): UpdateCustomerAccountRequest
    {
        $this->uuid = $uuid;
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
     * @return UpdateCustomerAccountRequest
     */
    public function setExternalId(string $external_id): UpdateCustomerAccountRequest
    {
        $this->external_id = $external_id;
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
     * @return UpdateCustomerAccountRequest
     */
    public function setAccountType(AccountType $account_type): UpdateCustomerAccountRequest
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
     * @return UpdateCustomerAccountRequest
     */
    public function setAccountNumber(string $account_number): UpdateCustomerAccountRequest
    {
        $this->account_number = $account_number;
        return $this;
    }
}
