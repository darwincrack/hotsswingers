<?php

namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Account;
use PaylandsSDK\Types\Customer;

/**
 * Class CreateCustomerAccountResponse
 * @package PaylandsSDK\Responses
 */
class CreateCustomerAccountResponse extends BaseResponse
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Account
     */
    private $customer_account;

    /**
     * CreateCustomerResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param Customer $customer
     * @param Account $account
     */
    public function __construct(string $message, int $code, string $current_time, Customer $customer, Account $account)
    {
        parent::__construct($message, $code, $current_time);
        $this->customer = $customer;
        $this->customer_account = $account;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return Account
     */
    public function getCustomerAccount()
    {
        return $this->customer_account;
    }
}
