<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\Card;
use PaylandsSDK\Types\Customer;

/**
 * Class ValidateTokenizedCardResponse
 * @package PaylandsSDK\Responses
 */
class ValidateTokenizedCardResponse extends BaseResponse
{
    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var Card
     */
    private $source;

    /**
     * ValidateTokenizedCardResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param Customer $customer
     * @param Card $source
     */
    public function __construct(string $message, int $code, string $current_time, Customer $customer, Card $source)
    {
        parent::__construct($message, $code, $current_time);
        $this->customer = $customer;
        $this->source = $source;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return Card
     */
    public function getSource()
    {
        return $this->source;
    }
}
