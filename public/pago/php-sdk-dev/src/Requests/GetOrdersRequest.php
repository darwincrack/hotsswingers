<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetOrdersRequest
 *
 * @package PaylandsSDK\Requests
 */
class GetOrdersRequest
{
    /**
     * @var string|null
     */
    private $start;
    /**
     * @var string|null
     */
    private $end;
    /**
     * @var string|null
     */
    private $terminal;

    /**
     * GetOrdersRequest constructor.
     * @param string|null $start
     * @param string|null $end
     * @param string|null $terminal
     */
    public function __construct(string $start = null, string $end = null, string $terminal = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->terminal = $terminal;
    }

    public function parseRequest(): array
    {
        return [
            "start" => $this->start,
            "end" => $this->end,
            "terminal" => $this->terminal
        ];
    }

    /**
     * @return string|null
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param string $start
     * @return GetOrdersRequest
     */
    public function setStart(string $start): GetOrdersRequest
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param string $end
     * @return GetOrdersRequest
     */
    public function setEnd(string $end): GetOrdersRequest
    {
        $this->end = $end;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTerminal()
    {
        return $this->terminal;
    }

    /**
     * @param string $terminal
     * @return GetOrdersRequest
     */
    public function setTerminal(string $terminal): GetOrdersRequest
    {
        $this->terminal = $terminal;
        return $this;
    }
}
