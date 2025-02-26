<?php

namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\CustomerAddress;

/**
 * Class CreateCustomerAddressResponse
 * @package PaylandsSDK\Responses
 */
class CreateCustomerAddressResponse extends BaseResponse
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var CustomerAddress
     */
    private $customer_address;

    /**
     * CreateCustomerResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param Customer $customer
     * @param CustomerAddress $address
     */
    public function __construct(string $message, int $code, string $current_time, Customer $customer, CustomerAddress $address)
    {
        parent::__construct($message, $code, $current_time);
        $this->customer = $customer;
        $this->customer_address = $address;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return CustomerAddress
     */
    public function getCustomerAddress()
    {
        return $this->customer_address;
    }
}
