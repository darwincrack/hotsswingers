<?php

namespace PaylandsSDK\Types;

/**
 * Class Branch
 * @package PaylandsSDK\Types
 */
class Branch
{
    /**
     * @var string
     */
    private $pay_agent_cd;
    /**
     * @var string
     */
    private $pay_agent_region_sd;
    /**
     * @var string
     */
    private $pay_agent_branch_sd;
    /**
     * @var string
     */
    private $pay_agent_branch_ds;
    /**
     * @var string
     */
    private $pay_agent_country_cd;
    /**
     * @var string
     */
    private $pay_agent_state_sd;
    /**
     * @var string
     */
    private $pay_agent_city;
    /**
     * @var string
     */
    private $pay_agent_address;
    /**
     * @var string
     */
    private $pay_agent_zipcode;
    /**
     * @var string
     */
    private $pay_agent_phone;
    /**
     * @var string
     */
    private $pay_agent_schedule;

    /**
     * Branch constructor.
     * @param string $pay_agent_cd
     * @param string $pay_agent_region_sd
     * @param string $pay_agent_branch_sd
     * @param string $pay_agent_branch_ds
     * @param string $pay_agent_country_cd
     * @param string $pay_agent_state_sd
     * @param string $pay_agent_city
     * @param string $pay_agent_address
     * @param string $pay_agent_zipcode
     * @param string $pay_agent_phone
     * @param string $pay_agent_schedule
     */
    public function __construct(
        string $pay_agent_cd,
        string $pay_agent_region_sd,
        string $pay_agent_branch_sd,
        string $pay_agent_branch_ds,
        string $pay_agent_country_cd,
        string $pay_agent_state_sd,
        string $pay_agent_city,
        string $pay_agent_address,
        string $pay_agent_zipcode,
        string $pay_agent_phone,
        string $pay_agent_schedule
    ) {
        $this->pay_agent_cd = $pay_agent_cd;
        $this->pay_agent_region_sd = $pay_agent_region_sd;
        $this->pay_agent_branch_sd = $pay_agent_branch_sd;
        $this->pay_agent_branch_ds = $pay_agent_branch_ds;
        $this->pay_agent_country_cd = $pay_agent_country_cd;
        $this->pay_agent_state_sd = $pay_agent_state_sd;
        $this->pay_agent_city = $pay_agent_city;
        $this->pay_agent_address = $pay_agent_address;
        $this->pay_agent_zipcode = $pay_agent_zipcode;
        $this->pay_agent_phone = $pay_agent_phone;
        $this->pay_agent_schedule = $pay_agent_schedule;
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
     * @return Branch
     */
    public function setPayAgentCd(string $pay_agent_cd): Branch
    {
        $this->pay_agent_cd = $pay_agent_cd;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentRegionSd()
    {
        return $this->pay_agent_region_sd;
    }

    /**
     * @param string $pay_agent_region_sd
     * @return Branch
     */
    public function setPayAgentRegionSd(string $pay_agent_region_sd): Branch
    {
        $this->pay_agent_region_sd = $pay_agent_region_sd;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentBranchSd()
    {
        return $this->pay_agent_branch_sd;
    }

    /**
     * @param string $pay_agent_branch_sd
     * @return Branch
     */
    public function setPayAgentBranchSd(string $pay_agent_branch_sd): Branch
    {
        $this->pay_agent_branch_sd = $pay_agent_branch_sd;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentBranchDs()
    {
        return $this->pay_agent_branch_ds;
    }

    /**
     * @param string $pay_agent_branch_ds
     * @return Branch
     */
    public function setPayAgentBranchDs(string $pay_agent_branch_ds): Branch
    {
        $this->pay_agent_branch_ds = $pay_agent_branch_ds;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentCountryCd()
    {
        return $this->pay_agent_country_cd;
    }

    /**
     * @param string $pay_agent_country_cd
     * @return Branch
     */
    public function setPayAgentCountryCd(string $pay_agent_country_cd): Branch
    {
        $this->pay_agent_country_cd = $pay_agent_country_cd;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentStateSd()
    {
        return $this->pay_agent_state_sd;
    }

    /**
     * @param string $pay_agent_state_sd
     * @return Branch
     */
    public function setPayAgentStateSd(string $pay_agent_state_sd): Branch
    {
        $this->pay_agent_state_sd = $pay_agent_state_sd;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentCity()
    {
        return $this->pay_agent_city;
    }

    /**
     * @param string $pay_agent_city
     * @return Branch
     */
    public function setPayAgentCity(string $pay_agent_city): Branch
    {
        $this->pay_agent_city = $pay_agent_city;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentAddress()
    {
        return $this->pay_agent_address;
    }

    /**
     * @param string $pay_agent_address
     * @return Branch
     */
    public function setPayAgentAddress(string $pay_agent_address): Branch
    {
        $this->pay_agent_address = $pay_agent_address;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentZipcode()
    {
        return $this->pay_agent_zipcode;
    }

    /**
     * @param string $pay_agent_zipcode
     * @return Branch
     */
    public function setPayAgentZipcode(string $pay_agent_zipcode): Branch
    {
        $this->pay_agent_zipcode = $pay_agent_zipcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentPhone()
    {
        return $this->pay_agent_phone;
    }

    /**
     * @param string $pay_agent_phone
     * @return Branch
     */
    public function setPayAgentPhone(string $pay_agent_phone): Branch
    {
        $this->pay_agent_phone = $pay_agent_phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayAgentSchedule()
    {
        return $this->pay_agent_schedule;
    }

    /**
     * @param string $pay_agent_schedule
     * @return Branch
     */
    public function setPayAgentSchedule(string $pay_agent_schedule): Branch
    {
        $this->pay_agent_schedule = $pay_agent_schedule;
        return $this;
    }
}
