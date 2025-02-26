<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetCustomerAccountRequest
 * @package PaylandsSDK\Requests
 */
class GetCustomerAccountRequest
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
     * @return GetCustomerAccountRequest
     */
    public function setUuid(string $uuid): GetCustomerAccountRequest
    {
        $this->uuid = $uuid;
        return $this;
    }
}
