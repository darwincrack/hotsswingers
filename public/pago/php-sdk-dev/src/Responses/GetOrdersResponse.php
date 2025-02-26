<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\TransactionOrder;

class GetOrdersResponse extends BaseResponse
{
    /**
     * @var integer
     */
    private $count;
    /**
     * @var TransactionOrder[]
     */
    private $transactions = [];

    /**
     * GetOrdersResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param int $count
     * @param array $transactions
     */
    public function __construct(string $message, int $code, string $current_time, int $count, array $transactions)
    {
        parent::__construct($message, $code, $current_time);
        $this->count = $count;
        $this->transactions = $transactions;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return TransactionOrder[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
}
