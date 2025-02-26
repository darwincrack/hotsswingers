<?php

namespace PaylandsSDK\Types;

/**
 * Class Phone
 */
class Phone
{
    /**
     * @var string|null
     */
    private $number;
    /**
     * @var string|null
     */
    private $prefix;

    /**
     * Phone constructor.
     * @param string|null $number
     * @param string|null $prefix
     */
    public function __construct(string $number = null, string $prefix = null)
    {
        $this->number = $number;
        $this->prefix = $prefix;
    }

    public function parseRequest(): array
    {
        return [
            "prefix" => $this->prefix,
            "number" => $this->number,
        ];
    }

    /**
     * @return string|null
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return Phone
     */
    public function setNumber(string $number): Phone
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return Phone
     */
    public function setPrefix(string $prefix): Phone
    {
        $this->prefix = $prefix;
        return $this;
    }
}
