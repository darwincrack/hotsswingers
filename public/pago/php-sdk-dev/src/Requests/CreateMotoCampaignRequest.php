<?php


namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\MoToCampaignType;

/**
 * Class CreateMotoCampaignRequest
 * @package PaylandsSDK\Requests
 */
class CreateMotoCampaignRequest
{
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $service_uuid;
    /**
     * @var MoToCampaignType
     */
    private $type;
    /**
     * @var string
     */
    private $expires_at;
    /**
     * @var string
     */
    private $file;
    /**
     * @var string|null
     */
    private $filename;

    /**
     * CreateMotoCampaignRequest constructor.
     * @param string $subject
     * @param string $description
     * @param string $service_uuid
     * @param MoToCampaignType $type
     * @param string $expires_at
     * @param string $file
     * @param string $filename
     */
    public function __construct(
        string $subject,
        string $description,
        string $service_uuid,
        MoToCampaignType $type,
        string $expires_at,
        string $file,
        string $filename = null
    ) {
        $this->subject = $subject;
        $this->description = $description;
        $this->service_uuid = $service_uuid;
        $this->type = $type;
        $this->expires_at = $expires_at;
        $this->file = $file;
        $this->filename = $filename;
    }

    public function parseRequest(): array
    {
        return [
            "subject" => $this->subject,
            "description" => $this->description,
            "service_uuid" => $this->service_uuid,
            "type" => $this->type->getValue(),
            "expires_at" => $this->expires_at,
            "file" => $this->file,
            "filename" => $this->filename,
        ];
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
     * @return CreateMotoCampaignRequest
     */
    public function setSubject(string $subject): CreateMotoCampaignRequest
    {
        $this->subject = $subject;
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
     * @return CreateMotoCampaignRequest
     */
    public function setDescription(string $description): CreateMotoCampaignRequest
    {
        $this->description = $description;
        return $this;
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
     * @return CreateMotoCampaignRequest
     */
    public function setServiceUuid(string $service_uuid): CreateMotoCampaignRequest
    {
        $this->service_uuid = $service_uuid;
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
     * @return CreateMotoCampaignRequest
     */
    public function setType(MoToCampaignType $type): CreateMotoCampaignRequest
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    /**
     * @param string $expires_at
     * @return CreateMotoCampaignRequest
     */
    public function setExpiresAt(string $expires_at): CreateMotoCampaignRequest
    {
        $this->expires_at = $expires_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     * @return CreateMotoCampaignRequest
     */
    public function setFile(string $file): CreateMotoCampaignRequest
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return CreateMotoCampaignRequest
     */
    public function setFilename(string $filename): CreateMotoCampaignRequest
    {
        $this->filename = $filename;
        return $this;
    }
}
