<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\CustomerProfile;

class CreateCustomerProfileResponse extends BaseResponse
{
    /**
     * @var CustomerProfile
     */
    private $customer_profile;

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
     * @param CustomerProfile $profile
     */
    public function __construct(string $message, int $code, string $current_time, Customer $customer, CustomerProfile $profile)
    {
        parent::__construct($message, $code, $current_time);
        $this->customer = $customer;
        $this->customer_profile = $profile;
    }

    /**
     * @return CustomerProfile
     */
    public function getCustomerProfile()
    {
        return $this->customer_profile;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
