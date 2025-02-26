<?php

namespace PaylandsSDK\Types;

/**
 * Class PaymentAgent
 * @package PaylandsSDK\Types
 */
class PaymentAgent
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $description;
    /**
     * @var array
     */

    /**
     * PaymentAgent constructor.
     * @param string $code
     * @param string $description
     */
    public function __construct(string $code, string $description)
    {
        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return PaymentAgent
     */
    public function setCode(string $code): PaymentAgent
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return PaymentAgent
     */
    public function setDescription(string $description): PaymentAgent
    {
        $this->description = $description;
        return $this;
    }
}
