<?php

namespace PaylandsSDK\Types;

/**
 * Class Client
 */
class Client
{
    /**
     * @var string $uuid
     */
    private $uuid;

    /**
     * Client constructor.
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
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
     * @return Client
     */
    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }
}
