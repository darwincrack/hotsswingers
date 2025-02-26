<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetStatesRequest
 * @package PaylandsSDK\Requests
 */
class GetStatesRequest
{
    /**
     * @var string
     */
    private $service_uuid;
    /**
     * @var string
     */
    private $country_cd;

    /**
     * GetStatesRequest constructor.
     * @param string $service_uuid
     * @param string $country_cd
     */
    public function __construct(string $service_uuid, string $country_cd)
    {
        $this->service_uuid = $service_uuid;
        $this->country_cd = $country_cd;
    }

    public function parseRequest(): array
    {
        return [
            "service_uuid" => $this->service_uuid,
            "country_cd" => $this->country_cd
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
     * @return GetStatesRequest
     */
    public function setServiceUuid(string $service_uuid): GetStatesRequest
    {
        $this->service_uuid = $service_uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCd()
    {
        return $this->country_cd;
    }

    /**
     * @param string $country_cd
     * @return GetStatesRequest
     */
    public function setCountryCd(string $country_cd): GetStatesRequest
    {
        $this->country_cd = $country_cd;
        return $this;
    }
}
