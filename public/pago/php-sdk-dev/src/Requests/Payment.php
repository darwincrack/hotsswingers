<?php


namespace PaylandsSDK\Requests;

/**
 * Class Payment
 *
 * @package PaylandsSDK\Requests
 */
class Payment
{
    /**
     * @var int
     */
    private $installments;

    /**
     * Payment constructor.
     * @param int $installments
     */
    public function __construct(int $installments)
    {
        $this->installments = $installments;
    }

    /**
     * @return int
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * @param int $installments
     * @return Payment
     */
    public function setInstallments(int $installments): Payment
    {
        $this->installments = $installments;
        return $this;
    }
}
