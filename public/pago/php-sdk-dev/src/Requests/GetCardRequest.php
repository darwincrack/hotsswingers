<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetCardRequest
 * @package PaylandsSDK\Requests
 */
class GetCardRequest
{
    /**
     * @var string
     */
    private $card_uuid;

    /**
     * GetCardRequest constructor.
     * @param string $card_uuid
     */
    public function __construct(string $card_uuid)
    {
        $this->card_uuid = $card_uuid;
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
     * @return GetCardRequest
     */
    public function setCardUuid(string $card_uuid): GetCardRequest
    {
        $this->card_uuid = $card_uuid;
        return $this;
    }
}
