<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\CardType;

/**
 * Class Card
 */
class Card
{
    /**
     * @var string
     */
    private $object;
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var CardType|string
     */
    private $type;
    /**
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $brand;
    /**
     * @var string
     */
    private $country;
    /**
     * @var string
     */
    private $holder;
    /**
     * @var string
     */
    private $bin;
    /**
     * @var string
     */
    private $last4;
    /**
     * @var string
     */
    private $expire_month;
    /**
     * @var string
     */
    private $expire_year;
    /**
     * @var string|null
     */
    private $additional;
    /**
     * @var string
     */
    private $bank;
    /**
     * @var string|null
     */
    private $validation_date;
    /**
     * @var string|null
     */
    private $prepaid;

    /**
     * Card constructor.
     * @param string $object
     * @param string $uuid
     * @param CardType|string $type
     * @param string $token
     * @param string $brand
     * @param string $country
     * @param string $holder
     * @param string $bin
     * @param string $last4
     * @param string $expire_month
     * @param string $expire_year
     * @param string $bank
     * @param string|null $validation_date
     * @param string|null $prepaid
     * @param string|null $additional
     */
    public function __construct(
        string $object,
        string $uuid,
        $type,
        string $token,
        string $brand,
        string $country,
        string $holder,
        string $bin,
        string $last4,
        string $expire_month,
        string $expire_year,
        string $bank,
        string $prepaid = null,
        string $validation_date = null,
        string $additional = null
    ) {
        $this->object = $object;
        $this->uuid = $uuid;
        $this->type = $type;
        $this->token = $token;
        $this->brand = $brand;
        $this->country = $country;
        $this->holder = $holder;
        $this->bin = $bin;
        $this->last4 = $last4;
        $this->expire_month = $expire_month;
        $this->expire_year = $expire_year;
        $this->additional = $additional;
        $this->bank = $bank;
        $this->validation_date = $validation_date;
        $this->prepaid = $prepaid;
    }

    /**
     * @param string $object
     * @return Card
     */
    public function setObject(string $object): Card
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return string
     */
    public function getObject()
    {
        return $this->object;
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
     * @return Card
     */
    public function setUuid(string $uuid): Card
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return CardType|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param CardType|string $type
     * @return Card
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Card
     */
    public function setToken(string $token): Card
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return Card
     */
    public function setBrand(string $brand): Card
    {
        $this->brand = $brand;
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
     * @return Card
     */
    public function setCountry(string $country): Card
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * @param string $holder
     * @return Card
     */
    public function setHolder(string $holder): Card
    {
        $this->holder = $holder;
        return $this;
    }

    /**
     * @return string
     */
    public function getBin()
    {
        return $this->bin;
    }

    /**
     * @param string $bin
     * @return Card
     */
    public function setBin(string $bin): Card
    {
        $this->bin = $bin;
        return $this;
    }

    /**
     * @return string
     */
    public function getLast4()
    {
        return $this->last4;
    }

    /**
     * @param string $last4
     * @return Card
     */
    public function setLast4(string $last4): Card
    {
        $this->last4 = $last4;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpireMonth()
    {
        return $this->expire_month;
    }

    /**
     * @param string $expire_month
     * @return Card
     */
    public function setExpireMonth(string $expire_month): Card
    {
        $this->expire_month = $expire_month;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpireYear()
    {
        return $this->expire_year;
    }

    /**
     * @param string $expire_year
     * @return Card
     */
    public function setExpireYear(string $expire_year): Card
    {
        $this->expire_year = $expire_year;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * @param string $additional
     * @return Card
     */
    public function setAdditional(string $additional): Card
    {
        $this->additional = $additional;
        return $this;
    }

    /**
     * @return string
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param string $bank
     * @return Card
     */
    public function setBank(string $bank): Card
    {
        $this->bank = $bank;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getValidationDate()
    {
        return $this->validation_date;
    }

    /**
     * @param string $validation_date
     * @return Card
     */
    public function setValidationDate(string $validation_date): Card
    {
        $this->validation_date = $validation_date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrepaid()
    {
        return $this->prepaid;
    }

    /**
     * @param string $prepaid
     * @return Card
     */
    public function setPrepaid(string $prepaid): Card
    {
        $this->prepaid = $prepaid;
        return $this;
    }
}
