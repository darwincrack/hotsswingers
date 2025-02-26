<?php

namespace PaylandsSDK\Types;

/**
 * Class State
 * @package PaylandsSDK\Types
 */
class State
{
    /**
     * @var string
     */
    private $state_sd;
    /**
     * @var string
     */
    private $state_cd;
    /**
     * @var string
     */
    private $country_cd;

    /**
     * State constructor.
     * @param string $state_sd
     * @param string $state_cd
     * @param string $country_cd
     */
    public function __construct(string $state_sd, string $state_cd, string $country_cd)
    {
        $this->state_sd = $state_sd;
        $this->state_cd = $state_cd;
        $this->country_cd = $country_cd;
    }

    /**
     * @return string
     */
    public function getStateSd()
    {
        return $this->state_sd;
    }

    /**
     * @param string $state_sd
     * @return State
     */
    public function setStateSd(string $state_sd): State
    {
        $this->state_sd = $state_sd;
        return $this;
    }

    /**
     * @return string
     */
    public function getStateCd()
    {
        return $this->state_cd;
    }

    /**
     * @param string $state_cd
     * @return State
     */
    public function setStateCd(string $state_cd): State
    {
        $this->state_cd = $state_cd;
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
     * @return State
     */
    public function setCountryCd(string $country_cd): State
    {
        $this->country_cd = $country_cd;
        return $this;
    }
}
