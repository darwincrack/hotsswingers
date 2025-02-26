<?php

namespace PaylandsSDK\Types;

/**
 * Class SubscriptionProduct
 */
class SubscriptionProduct
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
    private $sandbox;
    /**
     * @var string
     */
    private $notification_url;
    /**
     * @var string
     */
    private $created_at;
    /**
     * @var string
     */
    private $updated_at;

    /**
     * SubscriptionProduct constructor.
     * @param string $name
     * @param string $external_id
     * @param bool $sandbox
     * @param string $notification_url
     * @param string $created_at
     * @param string $updated_at
     */
    public function __construct(string $name, string $external_id, bool $sandbox, string $notification_url, string $created_at, string $updated_at)
    {
        $this->name = $name;
        $this->external_id = $external_id;
        $this->sandbox = $sandbox;
        $this->notification_url = $notification_url;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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
     * @return SubscriptionProduct
     */
    public function setName(string $name): SubscriptionProduct
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
     * @return SubscriptionProduct
     */
    public function setExternalId(string $external_id): SubscriptionProduct
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
     * @return SubscriptionProduct
     */
    public function setSandbox(bool $sandbox): SubscriptionProduct
    {
        $this->sandbox = $sandbox;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotificationUrl()
    {
        return $this->notification_url;
    }

    /**
     * @param string $notification_url
     * @return SubscriptionProduct
     */
    public function setNotificationUrl(string $notification_url): SubscriptionProduct
    {
        $this->notification_url = $notification_url;
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
     * @return SubscriptionProduct
     */
    public function setCreatedAt(string $created_at): SubscriptionProduct
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
     * @return SubscriptionProduct
     */
    public function setUpdatedAt(string $updated_at): SubscriptionProduct
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}
