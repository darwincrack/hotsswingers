<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetCustomerAddressRequest
 * @package PaylandsSDK\Requests
 */
class GetCustomerAddressRequest
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * CreateCustomerRequest constructor.
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
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
     * @return GetCustomerAddressRequest
     */
    public function setUuid(string $uuid): GetCustomerAddressRequest
    {
        $this->uuid = $uuid;
        return $this;
    }
}
