<?php


namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\Operative;

/**
 * Class SubscriptionAdditionalData
 * @package PaylandsSDK\Requests
 */
class SubscriptionAdditionalData
{
    /**
     * @var Operative
     */
    private $operative;
    /**
     * @var string
     */
    private $source_uuid;
    /**
     * @var string
     */
    private $customer_ext_id;
    /**
     * @var string
     */
    private $service;
    /**
     * @var string|null
     */
    private $additional;
    /**
     * @var string|null
     */
    private $url_post;

    /**
     * SubscriptionAdditionalData constructor.
     * @param Operative $operative
     * @param string $source_uuid
     * @param string $customer_ext_id
     * @param string $service
     * @param string $additional
     * @param string $url_post
     */
    public function __construct(
        Operative $operative,
        string $source_uuid,
        string $customer_ext_id,
        string $service,
        string $additional = null,
        string $url_post = null
    ) {
        $this->operative = $operative;
        $this->source_uuid = $source_uuid;
        $this->customer_ext_id = $customer_ext_id;
        $this->service = $service;
        $this->additional = $additional;
        $this->url_post = $url_post;
    }

    /**
     * @return Operative
     */
    public function getOperative()
    {
        return $this->operative;
    }

    /**
     * @param Operative $operative
     * @return SubscriptionAdditionalData
     */
    public function setOperative(Operative $operative): SubscriptionAdditionalData
    {
        $this->operative = $operative;
        return $this;
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
     * @return SubscriptionAdditionalData
     */
    public function setSourceUuid(string $source_uuid): SubscriptionAdditionalData
    {
        $this->source_uuid = $source_uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerExtId()
    {
        return $this->customer_ext_id;
    }

    /**
     * @param string $customer_ext_id
     * @return SubscriptionAdditionalData
     */
    public function setCustomerExtId(string $customer_ext_id): SubscriptionAdditionalData
    {
        $this->customer_ext_id = $customer_ext_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return SubscriptionAdditionalData
     */
    public function setService(string $service): SubscriptionAdditionalData
    {
        $this->service = $service;
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
     * @return SubscriptionAdditionalData
     */
    public function setAdditional(string $additional): SubscriptionAdditionalData
    {
        $this->additional = $additional;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlPost()
    {
        return $this->url_post;
    }

    /**
     * @param string $url_post
     * @return SubscriptionAdditionalData
     */
    public function setUrlPost(string $url_post): SubscriptionAdditionalData
    {
        $this->url_post = $url_post;
        return $this;
    }
}
