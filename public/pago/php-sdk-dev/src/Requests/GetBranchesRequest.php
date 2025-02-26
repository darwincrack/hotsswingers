<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetBranchesRequest
 * @package PaylandsSDK\Requests
 */
class GetBranchesRequest
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
     * GetBranchesRequest constructor.
     * @param string $service_uuid
     * @param string $pay_agent_cd
     */
    public function __construct(string $service_uuid, string $pay_agent_cd)
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
     * @return GetBranchesRequest
     */
    public function setServiceUuid(string $service_uuid): GetBranchesRequest
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
     * @return GetBranchesRequest
     */
    public function setPayAgentCd(string $pay_agent_cd): GetBranchesRequest
    {
        $this->pay_agent_cd = $pay_agent_cd;
        return $this;
    }
}
