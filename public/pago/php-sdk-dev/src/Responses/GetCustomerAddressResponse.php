<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\CustomerAddress;

/**
 * Class GetCustomerAddressResponse
 * @package PaylandsSDK\Responses
 */
class GetCustomerAddressResponse extends BaseResponse
{
    /**
     * @var CustomerAddress
     */
    private $customer_address;

    /**
     * GetCustomerAddressResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param CustomerAddress $address
     */
    public function __construct(string $message, int $code, string $current_time, CustomerAddress $address)
    {
        parent::__construct($message, $code, $current_time);
        $this->customer_address = $address;
    }

    /**
     * @return CustomerAddress
     */
    public function getCustomerAddress()
    {
        return $this->customer_address;
    }
}
