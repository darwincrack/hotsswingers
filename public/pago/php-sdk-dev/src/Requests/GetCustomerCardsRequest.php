<?php


namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\CardStatus;

/**
 * Class GetCustomerCardsRequest
 * @package PaylandsSDK\Requests
 */
class GetCustomerCardsRequest
{
    /**
     * @var string
     */
    private $customer_ext_id;
    /**
     * @var CardStatus|null
     */
    private $status;
    /**
     * @var boolean|null
     */
    private $unique;

    /**
     * GetCustomerCardsRequest constructor.
     * @param string $customer_ext_id
     * @param CardStatus $status
     * @param bool $unique
     */
    public function __construct(string $customer_ext_id, CardStatus $status = null, bool $unique = null)
    {
        $this->customer_ext_id = $customer_ext_id;
        $this->status = $status;
        $this->unique = $unique;
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
     * @return GetCustomerCardsRequest
     */
    public function setCustomerExtId(string $customer_ext_id): GetCustomerCardsRequest
    {
        $this->customer_ext_id = $customer_ext_id;
        return $this;
    }

    /**
     * @return CardStatus|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param CardStatus $status
     * @return GetCustomerCardsRequest
     */
    public function setStatus(CardStatus $status): GetCustomerCardsRequest
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUnique()
    {
        return $this->unique ?? false;
    }

    /**
     * @param bool $unique
     * @return GetCustomerCardsRequest
     */
    public function setUnique(bool $unique): GetCustomerCardsRequest
    {
        $this->unique = $unique;
        return $this;
    }
}
