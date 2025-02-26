<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\PaymentTypeCd;

/**
 * Class PaymentType
 * @package PaylandsSDK\Types
 */
class PaymentType
{
    /**
     * @var string
     */
    private $pay_agent_cd;
    /**
     * @var PaymentTypeCd
     */
    private $payment_type_cd;
    /**
     * @var string
     */
    private $dest_country_cd;
    /**
     * @var string
     */
    private $dest_currency_cd;

    /**
     * PaymentType constructor.
     * @param string $pay_agent_cd
     * @param PaymentTypeCd $payment_type_cd
     * @param string $dest_country_cd
     * @param string $dest_currency_cd
     */
    public function __construct(string $pay_agent_cd, PaymentTypeCd $payment_type_cd, string $dest_country_cd, string $dest_currency_cd)
    {
        $this->pay_agent_cd = $pay_agent_cd;
        $this->payment_type_cd = $payment_type_cd;
        $this->dest_country_cd = $dest_country_cd;
        $this->dest_currency_cd = $dest_currency_cd;
    }

    /**
     * @return string
     */
    public function getPayAgentCd()
    {
        return $this->pay_agent_cd;
    }

    /**
     * @param string $pay_agent_cd
     * @return PaymentType
     */
    public function setPayAgentCd(string $pay_agent_cd): PaymentType
    {
        $this->pay_agent_cd = $pay_agent_cd;
        return $this;
    }

    /**
     * @return PaymentTypeCd
     */
    public function getPaymentTypeCd()
    {
        return $this->payment_type_cd;
    }

    /**
     * @param PaymentTypeCd $payment_type_cd
     * @return PaymentType
     */
    public function setPaymentTypeCd(PaymentTypeCd $payment_type_cd): PaymentType
    {
        $this->payment_type_cd = $payment_type_cd;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestCountryCd()
    {
        return $this->dest_country_cd;
    }

    /**
     * @param string $dest_country_cd
     * @return PaymentType
     */
    public function setDestCountryCd(string $dest_country_cd): PaymentType
    {
        $this->dest_country_cd = $dest_country_cd;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestCurrencyCd()
    {
        return $this->dest_currency_cd;
    }

    /**
     * @param string $dest_currency_cd
     * @return PaymentType
     */
    public function setDestCurrencyCd(string $dest_currency_cd): PaymentType
    {
        $this->dest_currency_cd = $dest_currency_cd;
        return $this;
    }
}
