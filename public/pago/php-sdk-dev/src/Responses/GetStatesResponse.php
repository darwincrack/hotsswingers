<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\State;

/**
 * Class GetStatesResponse
 * @package PaylandsSDK\Responses
 */
class GetStatesResponse extends BaseResponse
{
    /**
     * @var State[]
     */
    private $states;

    /**
     * GetStatesResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $states
     */
    public function __construct(string $message, int $code, string $current_time, array $states)
    {
        parent::__construct($message, $code, $current_time);
        $this->states = $states;
    }

    /**
     * @return State[]
     */
    public function getStates()
    {
        return $this->states;
    }
}
