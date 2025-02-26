<?php


namespace PaylandsSDK\Requests;

/**
 * Class SaveCardsRequest
 * @package PaylandsSDK\Requests
 */
class SaveCardsRequest
{
    /**
     * @var CustomerCardRequest[]
     */
    private $cards;

    /**
     * SaveCardsRequest constructor.
     * @param CustomerCardRequest[] $cards
     */
    public function __construct(array $cards = [])
    {
        $this->cards = $cards;
    }

    public function parseRequest(): array
    {
        return [
            "cards" => array_map(function (CustomerCardRequest $customerCardRequest) {
                return $customerCardRequest->parseRequest();
            }, $this->cards)
        ];
    }

    /**
     * @param CustomerCardRequest $card
     * @return void
     */
    public function addCard(CustomerCardRequest $card)
    {
        $this->cards[] = $card;
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param array $cards
     * @return SaveCardsRequest
     */
    public function setCards(array $cards): SaveCardsRequest
    {
        $this->cards = $cards;
        return $this;
    }
}
