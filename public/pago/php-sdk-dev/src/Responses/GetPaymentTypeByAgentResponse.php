<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\PaymentType;

/**
 * Class GetPaymentTypeByAgentResponse
 * @package PaylandsSDK\Responses
 */
class GetPaymentTypeByAgentResponse extends BaseResponse
{
    /**
     * @var PaymentType[]
     */
    private $payment_types;

    /**
     * GetPaymentTypeByAgentResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $payment_types
     */
    public function __construct(string $message, int $code, string $current_time, array $payment_types)
    {
        parent::__construct($message, $code, $current_time);
        $this->payment_types = $payment_types;
    }

    /**
     * @return array
     */
    public function getPaymentTypes()
    {
        return $this->payment_types;
    }
}
