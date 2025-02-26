<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\PaymentAgent;

/**
 * Class GetPaymentAgentsResponse
 * @package PaylandsSDK\Responses
 */
class GetPaymentAgentsResponse extends BaseResponse
{
    /**
     * @var PaymentAgent[]
     */
    private $paymentAgents;

    /**
     * GetPaymentAgentsResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $paymentAgents
     */
    public function __construct(string $message, int $code, string $current_time, array $paymentAgents)
    {
        parent::__construct($message, $code, $current_time);
        $this->paymentAgents = $paymentAgents;
    }

    /**
     * @return array
     */
    public function getPaymentAgents()
    {
        return $this->paymentAgents;
    }
}
