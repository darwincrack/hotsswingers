<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\CustomerProfile;

/**
 * Class GetCustomerProfileResponse
 * @package PaylandsSDK\Responses
 */
class GetCustomerProfileResponse extends BaseResponse
{
    /**
     * @var CustomerProfile
     */
    private $customer_profile;


    /**
     * GetCustomerProfileResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param CustomerProfile $profile
     */
    public function __construct(string $message, int $code, string $current_time, CustomerProfile $profile)
    {
        parent::__construct($message, $code, $current_time);
        $this->customer_profile = $profile;
    }

    /**
     * @return CustomerProfile
     */
    public function getCustomerProfile()
    {
        return $this->customer_profile;
    }
}
