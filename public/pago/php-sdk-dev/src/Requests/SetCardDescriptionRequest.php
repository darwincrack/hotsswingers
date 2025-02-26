<?php


namespace PaylandsSDK\Requests;

/**
 * Class SetCardDescriptionRequest
 * @package PaylandsSDK\Requests
 */
class SetCardDescriptionRequest
{
    /**
     * @var string
     */
    private $source_uuid;
    /**
     * @var string|null
     */
    private $additional;

    /**
     * SetCardDescriptionRequest constructor.
     * @param string $source_uuid
     * @param string|null $additional
     */
    public function __construct(string $source_uuid, string $additional = null)
    {
        $this->source_uuid = $source_uuid;
        $this->additional = $additional;
    }

    public function parseRequest(): array
    {
        return [
            "source_uuid" => $this->source_uuid,
            "additional" => $this->additional
        ];
    }


    /**
     * @return string
     */
    public function getSourceUuid()
    {
        return $this->source_uuid;
    }

    /**
     * @param string $source_uuid
     * @return SetCardDescriptionRequest
     */
    public function setSourceUuid(string $source_uuid): SetCardDescriptionRequest
    {
        $this->source_uuid = $source_uuid;
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
     * @return SetCardDescriptionRequest
     */
    public function setAdditional(string $additional): SetCardDescriptionRequest
    {
        $this->additional = $additional;
        return $this;
    }
}
