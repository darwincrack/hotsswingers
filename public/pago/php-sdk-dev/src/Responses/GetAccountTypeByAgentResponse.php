<?php


namespace PaylandsSDK\Responses;

/**
 * Class GetAccountTypeByAgentResponse
 * @package PaylandsSDK\Responses
 */
class GetAccountTypeByAgentResponse extends BaseResponse
{
    /**
     * @var array
     */
    private $accounts;

    /**
     * GetAccountTypeByAgentResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $accounts
     */
    public function __construct(string $message, int $code, string $current_time, array $accounts)
    {
        parent::__construct($message, $code, $current_time);
        $this->message = $message;
        $this->accounts = $accounts;
    }

    /**
     * @return array
     */
    public function getAccounts()
    {
        return $this->accounts;
    }
}
