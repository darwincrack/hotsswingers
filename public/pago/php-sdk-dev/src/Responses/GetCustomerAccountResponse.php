<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Account;

/**
 * Class GetCustomerAccountResponse
 * @package PaylandsSDK\Responses
 */
class GetCustomerAccountResponse extends BaseResponse
{
    /**
     * @var Account
     */
    private $customer_account;

    /**
     * GetCustomerAccountResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param Account $account
     */
    public function __construct(string $message, int $code, string $current_time, Account $account)
    {
        parent::__construct($message, $code, $current_time);
        $this->customer_account = $account;
    }

    /**
     * @return Account
     */
    public function getCustomerAccount()
    {
        return $this->customer_account;
    }
}
