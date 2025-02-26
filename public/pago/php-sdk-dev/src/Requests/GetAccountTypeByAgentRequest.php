<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetAccountTypeByAgentRequest
 * @package PaylandsSDK\Requests
 */
class GetAccountTypeByAgentRequest
{

    /**
     * @var string
     */
    private $service_uuid;
    /**
     * @var string
     */
    private $pay_agent_cd;
    /**
     * @var string
     */
    private $country_cd;
    /**
     * @var string
     */
    private $currency_cd;

    /**
     * GetAccountTypeByAgentRequest constructor.
     * @param string $service_uuid
     * @param string $pay_agent_cd
     * @param string $country_cd
     * @param string $currency_cd
     */
    public function __construct(string $service_uuid, string $pay_agent_cd, string $country_cd, string $currency_cd)
    {
        $this->service_uuid = $service_uuid;
        $this->pay_agent_cd = $pay_agent_cd;
        $this->country_cd = $country_cd;
        $this->currency_cd = $currency_cd;
    }

    public function parseRequest(): array
    {
        return [
            "service_uuid" => $this->service_uuid,
            "pay_agent_cd" => $this->pay_agent_cd,
            "country_cd" => $this->country_cd,
            "currency_cd" => $this->currency_cd
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
     * @return GetAccountTypeByAgentRequest
     */
    public function setServiceUuid(string $service_uuid): GetAccountTypeByAgentRequest
    {
        $this->service_uuid = $service_uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentCd()
    {
        return $this->pay_agent_cd;
    }

    /**
     * @param string $pay_agent_cd
     * @return GetAccountTypeByAgentRequest
     */
    public function setPayAgentCd(string $pay_agent_cd): GetAccountTypeByAgentRequest
    {
        $this->pay_agent_cd = $pay_agent_cd;
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
     * @return GetAccountTypeByAgentRequest
     */
    public function setCountryCd(string $country_cd): GetAccountTypeByAgentRequest
    {
        $this->country_cd = $country_cd;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCd()
    {
        return $this->currency_cd;
    }

    /**
     * @param string $currency_cd
     * @return GetAccountTypeByAgentRequest
     */
    public function setCurrencyCd(string $currency_cd): GetAccountTypeByAgentRequest
    {
        $this->currency_cd = $currency_cd;
        return $this;
    }
}
