<?php

namespace PaylandsSDK\Responses;

/**
 * Class BaseResponse
 */
class BaseResponse
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $current_time;

    /**
     * BaseResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     */
    public function __construct(string $message, int $code, string $current_time)
    {
        $this->message = $message;
        $this->code = $code;
        $this->current_time = $current_time;
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
     * @return string
     */
    public function getCurrentTime()
    {
        return $this->current_time;
    }
}
