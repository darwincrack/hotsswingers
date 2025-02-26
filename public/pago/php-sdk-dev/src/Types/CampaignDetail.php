<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\EntryType;
use PaylandsSDK\Types\Enums\MoToCampaignStatus;
use PaylandsSDK\Types\Enums\MoToCampaignType;

/**
 * Class CampaignDetail
 */
class CampaignDetail
{
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $serviceUUID;
    /**
     * @var string
     */
    private $clientID;
    /**
     * @var string
     */
    private $clientUUID;
    /**
     * @var MoToCampaignType
     */
    private $type;
    /**
     * @var EntryType
     */
    private $entry;
    /**
     * @var string
     */
    private $expiresAt;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $filename;
    /**
     * @var string|null
     */
    private $error = null;

    /**
     * @var int
     */
    private $id;

    /**
     * @var MoToCampaignStatus
     */
    private $status;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * CampaignDetail constructor.
     * @param string $uuid
     * @param string $description
     * @param string $serviceUUID
     * @param string $clientID
     * @param string $clientUUID
     * @param MoToCampaignType $type
     * @param EntryType $entry
     * @param string $expiresAt
     * @param string $subject
     * @param string $filename
     * @param string $error
     * @param int $id
     * @param MoToCampaignStatus $status
     * @param string $createdAt
     */
    public function __construct(
        string $uuid,
        string $description,
        string $serviceUUID,
        string $clientID,
        string $clientUUID,
        MoToCampaignType $type,
        EntryType $entry,
        string $expiresAt,
        string $subject,
        string $filename,
        int $id,
        MoToCampaignStatus $status,
        string $createdAt,
        string $error = null
    ) {
        $this->uuid = $uuid;
        $this->description = $description;
        $this->serviceUUID = $serviceUUID;
        $this->clientID = $clientID;
        $this->clientUUID = $clientUUID;
        $this->type = $type;
        $this->entry = $entry;
        $this->expiresAt = $expiresAt;
        $this->subject = $subject;
        $this->filename = $filename;
        $this->error = $error;
        $this->id = $id;
        $this->status = $status;
        $this->createdAt = $createdAt;
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
     * @return CampaignDetail
     */
    public function setUuid(string $uuid): CampaignDetail
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return CampaignDetail
     */
    public function setDescription(string $description): CampaignDetail
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceUUID()
    {
        return $this->serviceUUID;
    }

    /**
     * @param string $serviceUUID
     * @return CampaignDetail
     */
    public function setServiceUUID(string $serviceUUID): CampaignDetail
    {
        $this->serviceUUID = $serviceUUID;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * @param string $clientID
     * @return CampaignDetail
     */
    public function setClientID(string $clientID): CampaignDetail
    {
        $this->clientID = $clientID;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientUUID()
    {
        return $this->clientUUID;
    }

    /**
     * @param string $clientUUID
     * @return CampaignDetail
     */
    public function setClientUUID(string $clientUUID): CampaignDetail
    {
        $this->clientUUID = $clientUUID;
        return $this;
    }

    /**
     * @return MoToCampaignType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param MoToCampaignType $type
     * @return CampaignDetail
     */
    public function setType(MoToCampaignType $type): CampaignDetail
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return EntryType
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param EntryType $entry
     * @return CampaignDetail
     */
    public function setEntry(EntryType $entry): CampaignDetail
    {
        $this->entry = $entry;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param string $expiresAt
     * @return CampaignDetail
     */
    public function setExpiresAt(string $expiresAt): CampaignDetail
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return CampaignDetail
     */
    public function setSubject(string $subject): CampaignDetail
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return CampaignDetail
     */
    public function setFilename(string $filename): CampaignDetail
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     * @return CampaignDetail
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return CampaignDetail
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param MoToCampaignStatus $status
     * @return CampaignDetail
     */
    public function setStatus(MoToCampaignStatus $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return CampaignDetail
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
