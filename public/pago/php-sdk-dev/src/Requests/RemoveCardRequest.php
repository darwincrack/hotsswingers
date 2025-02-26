<?php


namespace PaylandsSDK\Requests;

/**
 * Class RemoveCardRequest
 * @package PaylandsSDK\Requests
 */
class RemoveCardRequest
{
    /**
     * @var string
     */
    private $card_uuid;
    /**
     * @var string
     */
    private $customer_external_id;

    /**
     * RemoveCardRequest constructor.
     * @param string $card_uuid
     * @param string $customer_external_id
     */
    public function __construct(string $card_uuid, string $customer_external_id)
    {
        $this->card_uuid = $card_uuid;
        $this->customer_external_id = $customer_external_id;
    }

    public function parseRequest(): array
    {
        return [
            "card_uuid" => $this->card_uuid,
            "customer_external_id" => $this->customer_external_id
        ];
    }


    /**
     * @return string
     */
    public function getCardUuid()
    {
        return $this->card_uuid;
    }

    /**
     * @param string $card_uuid
     * @return RemoveCardRequest
     */
    public function setCardUuid(string $card_uuid): RemoveCardRequest
    {
        $this->card_uuid = $card_uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerExternalId()
    {
        return $this->customer_external_id;
    }

    /**
     * @param string $customer_external_id
     * @return RemoveCardRequest
     */
    public function setCustomerExternalId(string $customer_external_id): RemoveCardRequest
    {
        $this->customer_external_id = $customer_external_id;
        return $this;
    }
}
