<?php

declare(strict_types=1);

namespace PaylandsSDK\Types;

class ErrorResponse
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string|null
     */
    private $details;

    public function __construct(string $message, int $code, string $details = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getDetails()
    {
        return $this->details;
    }
}
