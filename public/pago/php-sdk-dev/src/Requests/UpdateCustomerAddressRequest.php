<?php


namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\AddressType;

/**
 * Class UpdateCustomerAddressRequest
 * @package PaylandsSDK\Requests
 */
class UpdateCustomerAddressRequest
{
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var string
     */
    private $external_id;
    /**
     * @var string
     */
    private $address1;
    /**
     * @var string|null
     */
    private $address2;
    /**
     * @var string|null
     */
    private $address3;
    /**
     * @var string
     */
    private $city;
    /**
     * @var string
     */
    private $state_code;
    /**
     * @var string
     */
    private $country;
    /**
     * @var string
     */
    private $zip_code;
    /**
     * @var AddressType
     */
    private $type;
    /**
     * @var boolean
     */
    private $default = false;

    /**
     * CreateCustomerAddressRequest constructor.
     * @param string $uuid
     * @param string $external_id
     * @param string $address1
     * @param string $city
     * @param string $state_code
     * @param string $country
     * @param string $zip_code
     * @param AddressType $type
     * @param bool $default
     * @param string $address2
     * @param string $address3
     */
    public function __construct(
        string $uuid,
        string $external_id,
        string $address1,
        string $city,
        string $state_code,
        string $country,
        string $zip_code,
        AddressType $type,
        bool $default = false,
        string $address2 = null,
        string $address3 = null
    ) {
        $this->uuid = $uuid;
        $this->external_id = $external_id;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->address3 = $address3;
        $this->city = $city;
        $this->state_code = $state_code;
        $this->country = $country;
        $this->zip_code = $zip_code;
        $this->type = $type;
        $this->default = $default;
    }

    public function parseRequest(): array
    {
        return [
            "external_id" => $this->external_id,
            "address1" => $this->address1,
            "address2" => $this->address2,
            "address3" => $this->address3,
            "city" => $this->city,
            "state_code" => $this->state_code,
            "country" => $this->country,
            "zip_code" => $this->zip_code,
            "type" => $this->type->getValue(),
            "default" => $this->default
        ];
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return UpdateCustomerAddressRequest
     */
    public function setUuid(string $uuid): UpdateCustomerAddressRequest
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * @param string $external_id
     * @return UpdateCustomerAddressRequest
     */
    public function setExternalId(string $external_id): UpdateCustomerAddressRequest
    {
        $this->external_id = $external_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     * @return UpdateCustomerAddressRequest
     */
    public function setAddress1(string $address1): UpdateCustomerAddressRequest
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     * @return UpdateCustomerAddressRequest
     */
    public function setAddress2(string $address2): UpdateCustomerAddressRequest
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress3()
    {
        return $this->address3;
    }

    /**
     * @param string $address3
     * @return UpdateCustomerAddressRequest
     */
    public function setAddress3(string $address3): UpdateCustomerAddressRequest
    {
        $this->address3 = $address3;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return UpdateCustomerAddressRequest
     */
    public function setCity(string $city): UpdateCustomerAddressRequest
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getStateCode()
    {
        return $this->state_code;
    }

    /**
     * @param string $state_code
     * @return UpdateCustomerAddressRequest
     */
    public function setStateCode(string $state_code): UpdateCustomerAddressRequest
    {
        $this->state_code = $state_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return UpdateCustomerAddressRequest
     */
    public function setCountry(string $country): UpdateCustomerAddressRequest
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * @param string $zip_code
     * @return UpdateCustomerAddressRequest
     */
    public function setZipCode(string $zip_code): UpdateCustomerAddressRequest
    {
        $this->zip_code = $zip_code;
        return $this;
    }

    /**
     * @return AddressType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param AddressType $type
     * @return UpdateCustomerAddressRequest
     */
    public function setType(AddressType $type): UpdateCustomerAddressRequest
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * @param bool $default
     * @return UpdateCustomerAddressRequest
     */
    public function setDefault(bool $default): UpdateCustomerAddressRequest
    {
        $this->default = $default;
        return $this;
    }
}
