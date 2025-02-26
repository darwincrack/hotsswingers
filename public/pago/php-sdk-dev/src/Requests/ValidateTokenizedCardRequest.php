<?php


namespace PaylandsSDK\Requests;

/**
 * Class ValidateTokenizedCardRequest
 * @package PaylandsSDK\Requests
 */
class ValidateTokenizedCardRequest
{
    /**
     * @var string
     */
    private $customer_ext_id;
    /**
     * @var string
     */
    private $service;
    /**
     * @var string
     */
    private $card_cvv;
    /**
     * @var string
     */
    private $source_uuid;

    /**
     * ValidateTokenizedCardRequest constructor.
     * @param string $source_uuid
     * @param string $customer_ext_id
     * @param string $service
     * @param string $card_cvv
     */
    public function __construct(string $source_uuid, string $customer_ext_id, string $service, string $card_cvv)
    {
        $this->customer_ext_id = $customer_ext_id;
        $this->service = $service;
        $this->card_cvv = $card_cvv;
        $this->source_uuid = $source_uuid;
    }

    public function parseRequest(): array
    {
        return [
            "source_uuid" => $this->source_uuid,
            "customer_ext_id" => $this->customer_ext_id,
            "service" => $this->service,
            "card_cvv" => $this->card_cvv
        ];
    }


    /**
     * @return string
     */
    public function getCustomerExtId()
    {
        return $this->customer_ext_id;
    }

    /**
     * @param string $customer_ext_id
     * @return ValidateTokenizedCardRequest
     */
    public function setCustomerExtId(string $customer_ext_id): ValidateTokenizedCardRequest
    {
        $this->customer_ext_id = $customer_ext_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return ValidateTokenizedCardRequest
     */
    public function setService(string $service): ValidateTokenizedCardRequest
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardCvv()
    {
        return $this->card_cvv;
    }

    /**
     * @param string $card_cvv
     * @return ValidateTokenizedCardRequest
     */
    public function setCardCvv(string $card_cvv): ValidateTokenizedCardRequest
    {
        $this->card_cvv = $card_cvv;
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceUuid()
    {
        return $this->source_uuid;
    }

    /**
     * @param string $source_uuid
     * @return ValidateTokenizedCardRequest
     */
    public function setSourceUuid(string $source_uuid): ValidateTokenizedCardRequest
    {
        $this->source_uuid = $source_uuid;
        return $this;
    }
}
