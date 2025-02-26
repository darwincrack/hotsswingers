<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\CustomerProfile;

class UpdateCustomerProfileResponse extends BaseResponse
{
    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var CustomerProfile
     */
    private $customer_profile;

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
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return CustomerProfile
     */
    public function getCustomerProfile()
    {
        return $this->customer_profile;
    }
}
