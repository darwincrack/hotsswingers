<?php

namespace PaylandsSDK\Types;

/**
 * Class Customer
 */
class Customer
{
    /**
     * @var string
     */
    private $external_id;
    /**
     * @var string|null
     */
    private $token;

    /**
     * Customer constructor.
     * @param string $external_id
     * @param string|null $token
     */
    public function __construct(string $external_id, string $token = null)
    {
        $this->external_id = $external_id;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * @param string $external_id
     * @return Customer
     */
    public function setExternalId(string $external_id): Customer
    {
        $this->external_id = $external_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Customer
     */
    public function setToken(string $token): Customer
    {
        $this->token = $token;
        return $this;
    }
}
