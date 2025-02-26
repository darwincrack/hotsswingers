<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\CustomerCard;

/**
 * Class SaveCardsResponse
 * @package PaylandsSDK\Responses
 */
class SaveCardsResponse extends BaseResponse
{
    /**
     * @var CustomerCard[]
     */
    private $cards;

    /**
     * SaveCardsResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $cards
     */
    public function __construct(string $message, int $code, string $current_time, array $cards)
    {
        parent::__construct($message, $code, $current_time);
        $this->cards = $cards;
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }
}
