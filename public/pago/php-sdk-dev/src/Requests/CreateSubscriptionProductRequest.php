<?php


namespace PaylandsSDK\Requests;

/**
 * Class CreateSubscriptionProductRequest
 * @package PaylandsSDK\Requests
 */
class CreateSubscriptionProductRequest
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $external_id;
    /**
     * @var boolean
     */
    private $sandbox = false;
    /**
     * @var string|null
     */
    private $notification_url;

    /**
     * CreateSubscriptionProductRequest constructor.
     * @param string $name
     * @param string $external_id
     * @param bool $sandbox
     * @param string $notification_url
     */
    public function __construct(
        string $name,
        string $external_id,
        bool $sandbox = false,
        string $notification_url = null
    ) {
        $this->name = $name;
        $this->external_id = $external_id;
        $this->sandbox = $sandbox;
        $this->notification_url = $notification_url;
    }

    public function parseRequest(): array
    {
        return [
            "name" => $this->name,
            "external_id" => $this->external_id,
            "sandbox" => $this->sandbox,
            "notification_url" => $this->notification_url
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CreateSubscriptionProductRequest
     */
    public function setName(string $name): CreateSubscriptionProductRequest
    {
        $this->name = $name;
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
     * @return CreateSubscriptionProductRequest
     */
    public function setExternalId(string $external_id): CreateSubscriptionProductRequest
    {
        $this->external_id = $external_id;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSandbox()
    {
        return $this->sandbox;
    }

    /**
     * @param bool $sandbox
     * @return CreateSubscriptionProductRequest
     */
    public function setSandbox(bool $sandbox): CreateSubscriptionProductRequest
    {
        $this->sandbox = $sandbox;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotificationUrl()
    {
        return $this->notification_url;
    }

    /**
     * @param string $notification_url
     * @return CreateSubscriptionProductRequest
     */
    public function setNotificationUrl(string $notification_url): CreateSubscriptionProductRequest
    {
        $this->notification_url = $notification_url;
        return $this;
    }
}
