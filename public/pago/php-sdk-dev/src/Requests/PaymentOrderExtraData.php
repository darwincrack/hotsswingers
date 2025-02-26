<?php


namespace PaylandsSDK\Requests;

/**
 * Class PaymentOrderExtraData
 * @package PaylandsSDK\Requests
 */
class PaymentOrderExtraData
{
    /**
     * @var Payment
     */
    private $payment;

    /**
     * PaymentOrderExtraData constructor.
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param Payment $payment
     * @return PaymentOrderExtraData
     */
    public function setPayment(Payment $payment): PaymentOrderExtraData
    {
        $this->payment = $payment;
        return $this;
    }
}
