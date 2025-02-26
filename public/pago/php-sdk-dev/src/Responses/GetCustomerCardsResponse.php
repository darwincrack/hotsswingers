<?php


namespace PaylandsSDK\Responses;

/**
 * Class GetCustomerCardsResponse
 * @package PaylandsSDK\Responses
 */
class GetCustomerCardsResponse extends BaseResponse
{
    /**
     * @var array
     */
    private $cards = [];

    /**
     * GetCustomerCardsResponse constructor.
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
