<?php

namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\DocumentIdentificationIssuer;
use PaylandsSDK\Types\Enums\DocumentIdentificationType;
use PaylandsSDK\Types\Phone;

/**
 * Class UpdateCustomerProfileRequest
 * @package PaylandsSDK\Requests
 */
class UpdateCustomerProfileRequest
{
    /**
     * @var string
     */
    private $external_id;
    /**
     * @var string
     */
    private $first_name;
    /**
     * @var string
     */
    private $last_name;
    /**
     * @var string|null
     */
    private $cardholder_name;
    /**
     * @var DocumentIdentificationIssuer
     */
    private $document_identification_issuer_type;
    /**
     * @var DocumentIdentificationType
     */
    private $document_identification_type;
    /**
     * @var string
     */
    private $document_identification_number;
    /**
     * @var Phone|null
     */
    private $phone;
    /**
     * @var Phone|null
     */
    private $home_phone;
    /**
     * @var Phone|null
     */
    private $work_phone;
    /**
     * @var Phone|null
     */
    private $mobile_phone;
    /**
     * @var string
     */
    private $birth_date;
    /**
     * @var string
     */
    private $source_of_funds;
    /**
     * @var string
     */
    private $occupation;
    /**
     * @var string
     */
    private $social_security_number;

    /**
     * CreateCustomerProfileRequest constructor.
     * @param string $external_id
     * @param string $first_name
     * @param string $last_name
     * @param string $cardholder_name
     * @param DocumentIdentificationIssuer $document_identification_issuer_type
     * @param DocumentIdentificationType $document_identification_type
     * @param string $document_identification_number
     * @param Phone|null $phone
     * @param Phone|null $work_phone
     * @param Phone|null $home_phone
     * @param Phone|null $mobile_phone
     * @param string $birth_date
     * @param string $source_of_funds
     * @param string $occupation
     * @param string $social_security_number
     */
    public function __construct(
        string $external_id,
        string $first_name,
        string $last_name,
        DocumentIdentificationIssuer $document_identification_issuer_type,
        DocumentIdentificationType $document_identification_type,
        string $document_identification_number,
        string $birth_date,
        string $source_of_funds,
        string $occupation,
        string $social_security_number,
        $cardholder_name = null,
        $phone = null,
        $work_phone = null,
        $home_phone = null,
        $mobile_phone = null
    ) {
        $this->external_id = $external_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->cardholder_name = $cardholder_name;
        $this->document_identification_issuer_type = $document_identification_issuer_type;
        $this->document_identification_type = $document_identification_type;
        $this->document_identification_number = $document_identification_number;
        $this->phone = $phone;
        $this->work_phone = $work_phone;
        $this->home_phone = $home_phone;
        $this->mobile_phone = $mobile_phone;
        $this->birth_date = $birth_date;
        $this->source_of_funds = $source_of_funds;
        $this->occupation = $occupation;
        $this->social_security_number = $social_security_number;
    }

    public function parseRequest(): array
    {
        return [
            "external_id" => $this->external_id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "cardholder_name" => $this->cardholder_name,
            "document_identification_issuer_type" => $this->document_identification_issuer_type->getValue(),
            "document_identification_type" => $this->document_identification_type->getValue(),
            "document_identification_number" => $this->document_identification_number,
            "phone" => is_null($this->phone) ? null : $this->phone->parseRequest(),
            "home_phone" => is_null($this->home_phone) ? null : $this->home_phone->parseRequest(),
            "mobile_phone" => is_null($this->mobile_phone) ? null : $this->mobile_phone->parseRequest(),
            "work_phone" => is_null($this->work_phone) ? null : $this->work_phone->parseRequest(),
            "birthdate" => $this->birth_date,
            "source_of_funds" => $this->source_of_funds,
            "occupation" => $this->occupation,
            "social_security_number" => $this->social_security_number,
        ];
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
     * @return UpdateCustomerProfileRequest
     */
    public function setExternalId(string $external_id): UpdateCustomerProfileRequest
    {
        $this->external_id = $external_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return UpdateCustomerProfileRequest
     */
    public function setFirstName(string $first_name): UpdateCustomerProfileRequest
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return UpdateCustomerProfileRequest
     */
    public function setLastName(string $last_name): UpdateCustomerProfileRequest
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardholderName()
    {
        return $this->cardholder_name;
    }

    /**
     * @param string $cardholder_name
     * @return UpdateCustomerProfileRequest
     */
    public function setCardholderName(string $cardholder_name): UpdateCustomerProfileRequest
    {
        $this->cardholder_name = $cardholder_name;
        return $this;
    }

    /**
     * @return DocumentIdentificationIssuer
     */
    public function getDocumentIdentificationIssuerType()
    {
        return $this->document_identification_issuer_type;
    }

    /**
     * @param DocumentIdentificationIssuer $document_identification_issuer_type
     * @return UpdateCustomerProfileRequest
     */
    public function setDocumentIdentificationIssuerType(DocumentIdentificationIssuer $document_identification_issuer_type): UpdateCustomerProfileRequest
    {
        $this->document_identification_issuer_type = $document_identification_issuer_type;
        return $this;
    }

    /**
     * @return DocumentIdentificationType
     */
    public function getDocumentIdentificationType()
    {
        return $this->document_identification_type;
    }

    /**
     * @param DocumentIdentificationType $document_identification_type
     * @return UpdateCustomerProfileRequest
     */
    public function setDocumentIdentificationType(DocumentIdentificationType $document_identification_type): UpdateCustomerProfileRequest
    {
        $this->document_identification_type = $document_identification_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentIdentificationNumber()
    {
        return $this->document_identification_number;
    }

    /**
     * @param string $document_identification_number
     * @return UpdateCustomerProfileRequest
     */
    public function setDocumentIdentificationNumber(string $document_identification_number): UpdateCustomerProfileRequest
    {
        $this->document_identification_number = $document_identification_number;
        return $this;
    }

    /**
     * @return Phone|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     * @return UpdateCustomerProfileRequest
     */
    public function setPhone(Phone $phone): UpdateCustomerProfileRequest
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return Phone|null
     */
    public function getHomePhone()
    {
        return $this->home_phone;
    }

    /**
     * @param Phone $home_phone
     * @return UpdateCustomerProfileRequest
     */
    public function setHomePhone(Phone $home_phone): UpdateCustomerProfileRequest
    {
        $this->home_phone = $home_phone;
        return $this;
    }

    /**
     * @return Phone|null
     */
    public function getWorkPhone()
    {
        return $this->work_phone;
    }

    /**
     * @param Phone $work_phone
     * @return UpdateCustomerProfileRequest
     */
    public function setWorkPhone(Phone $work_phone): UpdateCustomerProfileRequest
    {
        $this->work_phone = $work_phone;
        return $this;
    }

    /**
     * @return Phone|null
     */
    public function getMobilePhone()
    {
        return $this->mobile_phone;
    }

    /**
     * @param Phone $mobile_phone
     * @return UpdateCustomerProfileRequest
     */
    public function setMobilePhone(Phone $mobile_phone): UpdateCustomerProfileRequest
    {
        $this->mobile_phone = $mobile_phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * @param string $birth_date
     * @return UpdateCustomerProfileRequest
     */
    public function setBirthDate(string $birth_date): UpdateCustomerProfileRequest
    {
        $this->birth_date = $birth_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceOfFunds()
    {
        return $this->source_of_funds;
    }

    /**
     * @param string $source_of_funds
     * @return UpdateCustomerProfileRequest
     */
    public function setSourceOfFunds(string $source_of_funds): UpdateCustomerProfileRequest
    {
        $this->source_of_funds = $source_of_funds;
        return $this;
    }

    /**
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param string $occupation
     * @return UpdateCustomerProfileRequest
     */
    public function setOccupation(string $occupation): UpdateCustomerProfileRequest
    {
        $this->occupation = $occupation;
        return $this;
    }

    /**
     * @return string
     */
    public function getSocialSecurityNumber()
    {
        return $this->social_security_number;
    }

    /**
     * @param string $social_security_number
     * @return UpdateCustomerProfileRequest
     */
    public function setSocialSecurityNumber(string $social_security_number): UpdateCustomerProfileRequest
    {
        $this->social_security_number = $social_security_number;
        return $this;
    }
}
