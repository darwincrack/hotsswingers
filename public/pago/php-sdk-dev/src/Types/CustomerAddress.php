<?php


namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\AddressType;

class CustomerAddress
{
    /**
     * @var string
     */
    private $uuid;
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
     * @var AddressType|null
     */
    private $type;
    /**
     * @var boolean|null
     */
    private $default;

    /**
     * CustomerAddress constructor.
     * @param string $uuid
     * @param string $address1
     * @param string|null $address2
     * @param string|null $address3
     * @param string $city
     * @param string $state_code
     * @param string $country
     * @param string $zip_code
     * @param AddressType $type
     * @param bool $default
     */
    public function __construct(
        string $uuid,
        string $address1,
        $address2,
        $address3,
        string $city,
        string $state_code,
        string $country,
        string $zip_code,
        AddressType $type = null,
        bool $default = null
    ) {
        $this->uuid = $uuid;
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

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return CustomerAddress
     */
    public function setUuid(string $uuid): CustomerAddress
    {
        $this->uuid = $uuid;
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
     * @return CustomerAddress
     */
    public function setAddress1(string $address1): CustomerAddress
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
     * @return CustomerAddress
     */
    public function setAddress2(string $address2): CustomerAddress
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
     * @return CustomerAddress
     */
    public function setAddress3(string $address3): CustomerAddress
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
     * @return CustomerAddress
     */
    public function setCity(string $city): CustomerAddress
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
     * @return CustomerAddress
     */
    public function setStateCode(string $state_code): CustomerAddress
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
     * @return CustomerAddress
     */
    public function setCountry(string $country): CustomerAddress
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
     * @return CustomerAddress
     */
    public function setZipCode(string $zip_code): CustomerAddress
    {
        $this->zip_code = $zip_code;
        return $this;
    }

    /**
     * @return AddressType|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param AddressType $type
     * @return CustomerAddress
     */
    public function setType(AddressType $type): CustomerAddress
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->default ?? false;
    }

    /**
     * @param bool $default
     * @return CustomerAddress
     */
    public function setDefault(bool $default): CustomerAddress
    {
        $this->default = $default;
        return $this;
    }
}
