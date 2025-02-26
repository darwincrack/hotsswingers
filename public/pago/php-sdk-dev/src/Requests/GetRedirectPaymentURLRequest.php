<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetRedirectPaymentURLRequest
 * @package PaylandsSDK\Requests
 */
class GetRedirectPaymentURLRequest
{
    /**
     * @var string
     */
    private $token;

    /**
     * GetRedirectPaymentURLRequest constructor.
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
     * @return GetRedirectPaymentURLRequest
     */
    public function setToken(string $token): GetRedirectPaymentURLRequest
    {
        $this->token = $token;
        return $this;
    }
}
