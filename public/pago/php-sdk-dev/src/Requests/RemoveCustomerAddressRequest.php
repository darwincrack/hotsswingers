<?php


namespace PaylandsSDK\Requests;

/**
 * Class RemoveCustomerAddressRequest
 * @package PaylandsSDK\Requests
 */
class RemoveCustomerAddressRequest
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * RemoveCustomerAddressRequest constructor.
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function parseRequest(): array
    {
        return [
            "uuid" => $this->uuid,
        ];
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
     * @return RemoveCustomerAddressRequest
     */
    public function setUuid(string $uuid): RemoveCustomerAddressRequest
    {
        $this->uuid = $uuid;
        return $this;
    }
}
