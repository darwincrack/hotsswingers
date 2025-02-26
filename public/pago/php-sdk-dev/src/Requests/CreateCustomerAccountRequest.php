<?php


namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\AccountType;

/**
 * Class CreateCustomerAccountRequest
 * @package PaylandsSDK\Requests
 */
class CreateCustomerAccountRequest
{
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
     * @param string $external_id
     * @param AccountType $account_type
     * @param string $account_number
     */
    public function __construct(string $external_id, AccountType $account_type, string $account_number)
    {
        $this->external_id = $external_id;
        $this->account_type = $account_type;
        $this->account_number = $account_number;
    }

    public function parseRequest(): array
    {
        return [
            "external_id" => $this->external_id,
            "account_type" => $this->account_type->getValue(),
            "account_number" => $this->account_number,
        ];
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
     * @return CreateCustomerAccountRequest
     */
    public function setExternalId(string $external_id): CreateCustomerAccountRequest
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
     * @return CreateCustomerAccountRequest
     */
    public function setAccountType(AccountType $account_type): CreateCustomerAccountRequest
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
     * @return CreateCustomerAccountRequest
     */
    public function setAccountNumber(string $account_number): CreateCustomerAccountRequest
    {
        $this->account_number = $account_number;
        return $this;
    }
}
