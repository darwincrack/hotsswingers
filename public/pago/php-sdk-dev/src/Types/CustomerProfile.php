<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\DocumentIdentificationIssuer;
use PaylandsSDK\Types\Enums\DocumentIdentificationType;

/**
 * Class CustomerProfile
 */
class CustomerProfile
{
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
     * @var string|null
     */
    private $email;
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
    private $birthdate;
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
     * @var string
     */
    private $created_at;
    /**
     * @var string
     */
    private $updated_at;

    /**
     * CustomerProfile constructor.
     * @param string $first_name
     * @param string $last_name
     * @param string $cardholder_name
     * @param DocumentIdentificationIssuer $document_identification_issuer_type
     * @param DocumentIdentificationType $document_identification_type
     * @param string $document_identification_number
     * @param string $birthdate
     * @param string $source_of_funds
     * @param string $occupation
     * @param string $social_security_number
     * @param string $created_at
     * @param string $updated_at
     * @param string|null $email
     * @param Phone|null $phone
     * @param Phone|null $home_phone
     * @param Phone|null $work_phone
     * @param Phone|null $mobile_phone
     */
    public function __construct(
        string $first_name,
        string $last_name,
        string $cardholder_name,
        DocumentIdentificationIssuer $document_identification_issuer_type,
        DocumentIdentificationType $document_identification_type,
        string $document_identification_number,
        string $birthdate,
        string $source_of_funds,
        string $occupation,
        string $social_security_number,
        string $created_at,
        string $updated_at,
        string $email = null,
        Phone $phone = null,
        Phone $home_phone = null,
        Phone $work_phone = null,
        Phone $mobile_phone = null
    ) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->cardholder_name = $cardholder_name;
        $this->document_identification_issuer_type = $document_identification_issuer_type;
        $this->document_identification_type = $document_identification_type;
        $this->document_identification_number = $document_identification_number;
        $this->email = $email;
        $this->phone = $phone;
        $this->home_phone = $home_phone;
        $this->work_phone = $work_phone;
        $this->mobile_phone = $mobile_phone;
        $this->birthdate = $birthdate;
        $this->source_of_funds = $source_of_funds;
        $this->occupation = $occupation;
        $this->social_security_number = $social_security_number;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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
     * @return CustomerProfile
     */
    public function setFirstName(string $first_name): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setLastName(string $last_name): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setCardholderName(string $cardholder_name): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setDocumentIdentificationIssuerType(DocumentIdentificationIssuer $document_identification_issuer_type): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setDocumentIdentificationType(DocumentIdentificationType $document_identification_type): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setDocumentIdentificationNumber(string $document_identification_number): CustomerProfile
    {
        $this->document_identification_number = $document_identification_number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CustomerProfile
     */
    public function setEmail(string $email): CustomerProfile
    {
        $this->email = $email;
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
     * @return CustomerProfile
     */
    public function setPhone(Phone $phone): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setHomePhone(Phone $home_phone): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setWorkPhone(Phone $work_phone): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setMobilePhone(Phone $mobile_phone): CustomerProfile
    {
        $this->mobile_phone = $mobile_phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param string $birthdate
     * @return CustomerProfile
     */
    public function setBirthdate(string $birthdate): CustomerProfile
    {
        $this->birthdate = $birthdate;
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
     * @return CustomerProfile
     */
    public function setSourceOfFunds(string $source_of_funds): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setOccupation(string $occupation): CustomerProfile
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
     * @return CustomerProfile
     */
    public function setSocialSecurityNumber(string $social_security_number): CustomerProfile
    {
        $this->social_security_number = $social_security_number;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return CustomerProfile
     */
    public function setCreatedAt(string $created_at): CustomerProfile
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     * @return CustomerProfile
     */
    public function setUpdatedAt(string $updated_at): CustomerProfile
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}
