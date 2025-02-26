<?php


namespace PaylandsSDK\Requests;

/**
 * Class GetProductsRequest
 * @package PaylandsSDK\Requests
 */
class GetProductsRequest
{
    /**
     * @var string
     */
    private $service_uuid;
    /**
     * @var string
     */
    private $payment_type_cd;

    /**
     * GetProductsRequest constructor.
     * @param string $service_uuid
     * @param string $payment_type_cd
     */
    public function __construct(string $service_uuid, string $payment_type_cd)
    {
        $this->service_uuid = $service_uuid;
        $this->payment_type_cd = $payment_type_cd;
    }

    public function parseRequest(): array
    {
        return [
            "service_uuid" => $this->service_uuid,
            "payment_type_cd" => $this->payment_type_cd
        ];
    }

    /**
     * @return string
     */
    public function getServiceUuid()
    {
        return $this->service_uuid;
    }

    /**
     * @param string $service_uuid
     * @return GetProductsRequest
     */
    public function setServiceUuid(string $service_uuid): GetProductsRequest
    {
        $this->service_uuid = $service_uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentTypeCd()
    {
        return $this->payment_type_cd;
    }

    /**
     * @param string $payment_type_cd
     * @return GetProductsRequest
     */
    public function setPaymentTypeCd(string $payment_type_cd): GetProductsRequest
    {
        $this->payment_type_cd = $payment_type_cd;
        return $this;
    }
}
