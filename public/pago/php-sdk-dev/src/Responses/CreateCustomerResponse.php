<?php

namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Customer;

class CreateCustomerResponse extends BaseResponse
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * CreateCustomerResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param Customer $customer
     */
    public function __construct(string $message, int $code, string $current_time, Customer $customer)
    {
        parent::__construct($message, $code, $current_time);
        $this->customer = $customer;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
