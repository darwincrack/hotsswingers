<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetPaymentTypeByAgentRequest
 * @package PaylandsSDK\Requests
 */
class GetPaymentTypeByAgentRequest
{
    /**
     * @var string
     */
    private $service_uuid;
    /**
     * @var string|null
     */
    private $pay_agent_cd;


    /**
     * GetPaymentTypeByAgentRequest constructor.
     * @param string $service_uuid
     * @param string $pay_agent_cd
     */
    public function __construct(string $service_uuid, $pay_agent_cd = null)
    {
        $this->service_uuid = $service_uuid;
        $this->pay_agent_cd = $pay_agent_cd;
    }

    public function parseRequest(): array
    {
        return [
            "service_uuid" => $this->service_uuid,
            "pay_agent_cd" => $this->pay_agent_cd
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
     * @return GetPaymentTypeByAgentRequest
     */
    public function setServiceUuid(string $service_uuid): GetPaymentTypeByAgentRequest
    {
        $this->service_uuid = $service_uuid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPayAgentCd()
    {
        return $this->pay_agent_cd;
    }

    /**
     * @param string $pay_agent_cd
     * @return GetPaymentTypeByAgentRequest
     */
    public function setPayAgentCd(string $pay_agent_cd): GetPaymentTypeByAgentRequest
    {
        $this->pay_agent_cd = $pay_agent_cd;
        return $this;
    }
}
