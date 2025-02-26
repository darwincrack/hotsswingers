<?php


namespace PaylandsSDK\Requests;

/**
 * Class SendTokenizedPaymentRequest
 * @package PaylandsSDK\Requests
 */
class SendTokenizedPaymentRequest
{
    /**
     * @var string
     */
    private $token;

    /**
     * SendTokenizedPaymentRequest constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return SendTokenizedPaymentRequest
     */
    public function setToken(string $token): SendTokenizedPaymentRequest
    {
        $this->token = $token;
        return $this;
    }
}
