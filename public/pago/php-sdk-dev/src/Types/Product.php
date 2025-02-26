<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\PaymentTypeCd;

/**
 * Class Product
 * @package PaylandsSDK\Types
 */
class Product
{
    /**
     * @var string
     */
    private $serviceCode;
    /**
     * @var string
     */
    private $originCountryCode;
    /**
     * @var string
     */
    private $originCurrencyCode;
    /**
     * @var string
     */
    private $destinationCountryCode;
    /**
     * @var string
     */
    private $destinationCurrencyCode;
    /**
     * @var PaymentTypeCd
     */
    private $paymentTypeCode;
    /**
     * @var string
     */
    private $directedTransactionCode;
    /**
     * @var string
     */
    private $electronicFundsCode;

    /**
     * Product constructor.
     * @param string $serviceCode
     * @param string $originCountryCode
     * @param string $originCurrencyCode
     * @param string $destinationCountryCode
     * @param string $destinationCurrencyCode
     * @param PaymentTypeCd $paymentTypeCode
     * @param string $directedTransactionCode
     * @param string $electronicFundsCode
     */
    public function __construct(
        string $serviceCode,
        string $originCountryCode,
        string $originCurrencyCode,
        string $destinationCountryCode,
        string $destinationCurrencyCode,
        PaymentTypeCd $paymentTypeCode,
        string $directedTransactionCode,
        string $electronicFundsCode
    ) {
        $this->serviceCode = $serviceCode;
        $this->originCountryCode = $originCountryCode;
        $this->originCurrencyCode = $originCurrencyCode;
        $this->destinationCountryCode = $destinationCountryCode;
        $this->destinationCurrencyCode = $destinationCurrencyCode;
        $this->paymentTypeCode = $paymentTypeCode;
        $this->directedTransactionCode = $directedTransactionCode;
        $this->electronicFundsCode = $electronicFundsCode;
    }

    /**
     * @return string
     */
    public function getServiceCode()
    {
        return $this->serviceCode;
    }

    /**
     * @param string $serviceCode
     * @return Product
     */
    public function setServiceCode(string $serviceCode): Product
    {
        $this->serviceCode = $serviceCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginCountryCode()
    {
        return $this->originCountryCode;
    }

    /**
     * @param string $originCountryCode
     * @return Product
     */
    public function setOriginCountryCode(string $originCountryCode): Product
    {
        $this->originCountryCode = $originCountryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginCurrencyCode()
    {
        return $this->originCurrencyCode;
    }

    /**
     * @param string $originCurrencyCode
     * @return Product
     */
    public function setOriginCurrencyCode(string $originCurrencyCode): Product
    {
        $this->originCurrencyCode = $originCurrencyCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationCountryCode()
    {
        return $this->destinationCountryCode;
    }

    /**
     * @param string $destinationCountryCode
     * @return Product
     */
    public function setDestinationCountryCode(string $destinationCountryCode): Product
    {
        $this->destinationCountryCode = $destinationCountryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationCurrencyCode()
    {
        return $this->destinationCurrencyCode;
    }

    /**
     * @param string $destinationCurrencyCode
     * @return Product
     */
    public function setDestinationCurrencyCode(string $destinationCurrencyCode): Product
    {
        $this->destinationCurrencyCode = $destinationCurrencyCode;
        return $this;
    }

    /**
     * @return PaymentTypeCd
     */
    public function getPaymentTypeCode()
    {
        return $this->paymentTypeCode;
    }

    /**
     * @param PaymentTypeCd $paymentTypeCode
     * @return Product
     */
    public function setPaymentTypeCode(PaymentTypeCd $paymentTypeCode): Product
    {
        $this->paymentTypeCode = $paymentTypeCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirectedTransactionCode()
    {
        return $this->directedTransactionCode;
    }

    /**
     * @param string $directedTransactionCode
     * @return Product
     */
    public function setDirectedTransactionCode(string $directedTransactionCode): Product
    {
        $this->directedTransactionCode = $directedTransactionCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getElectronicFundsCode()
    {
        return $this->electronicFundsCode;
    }

    /**
     * @param string $electronicFundsCode
     * @return Product
     */
    public function setElectronicFundsCode(string $electronicFundsCode): Product
    {
        $this->electronicFundsCode = $electronicFundsCode;
        return $this;
    }
}
