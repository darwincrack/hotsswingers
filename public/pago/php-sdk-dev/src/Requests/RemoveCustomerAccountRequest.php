<?php


namespace PaylandsSDK\Requests;

/**
 * Class RemoveCustomerAccountRequest
 * @package PaylandsSDK\Requests
 */
class RemoveCustomerAccountRequest
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * RemoveCustomerAccountRequest constructor.
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function parseRequest(): array
    {
        return [
            "uuid" => $this->uuid
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
     * @return RemoveCustomerAccountRequest
     */
    public function setUuid(string $uuid): RemoveCustomerAccountRequest
    {
        $this->uuid = $uuid;
        return $this;
    }
}
