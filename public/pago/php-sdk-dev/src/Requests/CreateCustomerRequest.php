<?php

namespace PaylandsSDK\Requests;

/**
 * Class CreateCustomerRequest
 */
class CreateCustomerRequest
{
    /**
     * @var string
     */
    private $customer_ext_id;

    /**
     * CreateCustomerRequest constructor.
     * @param string $customer_ext_id
     */
    public function __construct(string $customer_ext_id)
    {
        $this->customer_ext_id = $customer_ext_id;
    }

    public function parseRequest(): array
    {
        return [
            "customer_ext_id" => $this->customer_ext_id
        ];
    }

    /**
     * @return string
     */
    public function getCustomerExtId()
    {
        return $this->customer_ext_id;
    }

    /**
     * @param string $customer_ext_id
     * @return CreateCustomerRequest
     */
    public function setCustomerExtId(string $customer_ext_id): CreateCustomerRequest
    {
        $this->customer_ext_id = $customer_ext_id;
        return $this;
    }
}
