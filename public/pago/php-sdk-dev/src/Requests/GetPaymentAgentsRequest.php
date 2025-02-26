<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetPaymentAgentsRequest
 * @package PaylandsSDK\Requests
 */
class GetPaymentAgentsRequest
{
    /**
     * @var string
     */
    private $service_uuid;

    /**
     * GetPaymentAgentsRequest constructor.
     * @param string $service_uuid
     */
    public function __construct(string $service_uuid)
    {
        $this->service_uuid = $service_uuid;
    }

    public function parseRequest(): array
    {
        return [
            "service_uuid" => $this->service_uuid
        ];
    }

    /**
     * @return string
     */
    public function getServiceUuid()
    {
        return $this->service_uuid;
    }

    /**
     * @param string $service_uuid
     * @return GetPaymentAgentsRequest
     */
    public function setServiceUuid(string $service_uuid): GetPaymentAgentsRequest
    {
        $this->service_uuid = $service_uuid;
        return $this;
    }
}
