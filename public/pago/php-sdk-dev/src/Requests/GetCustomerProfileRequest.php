<?php

namespace PaylandsSDK\Requests;

/**
 * Class GetCustomerProfileRequest
 */
class GetCustomerProfileRequest
{
    /**
     * @var string
     */
    private $external_id;

    /**
     * CreateCustomerRequest constructor.
     * @param string $external_id
     */
    public function __construct(string $external_id)
    {
        $this->external_id = $external_id;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * @param string $external_id
     * @return GetCustomerProfileRequest
     */
    public function setExternalId(string $external_id): GetCustomerProfileRequest
    {
        $this->external_id = $external_id;
        return $this;
    }
}
