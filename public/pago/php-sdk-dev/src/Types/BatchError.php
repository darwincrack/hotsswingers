<?php

namespace PaylandsSDK\Types;

/**
 * Class BatchError
 */
class BatchError
{
    /**
     * @var string
     */
    private $line;
    /**
     * @var string
     */
    private $msg;

    /**
     * BatchError constructor.
     * @param string $line
     * @param string $msg
     */
    public function __construct(string $line, string $msg)
    {
        $this->line = $line;
        $this->msg = $msg;
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param string $line
     * @return BatchError
     */
    public function setLine(string $line): BatchError
    {
        $this->line = $line;
        return $this;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     * @return BatchError
     */
    public function setMsg(string $msg): BatchError
    {
        $this->msg = $msg;
        return $this;
    }
}
