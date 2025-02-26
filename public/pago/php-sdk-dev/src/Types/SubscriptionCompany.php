<?php


namespace PaylandsSDK\Types;

class SubscriptionCompany
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $external_id
     */
    private $external_id;

    /**
     * @var string $created_at
     */
    private $created_at;

    /**
     * @var string $updated_at
     */
    private $updated_at;

    /**
     * SubscriptionCompany constructor.
     * @param string $name
     * @param string $external_id
     * @param string $created_at
     * @param string $updated_at
     */
    public function __construct(string $name, string $external_id, string $created_at, string $updated_at)
    {
        $this->name = $name;
        $this->external_id = $external_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return SubscriptionCompany
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * @param mixed $external_id
     * @return SubscriptionCompany
     */
    public function setExternalId($external_id)
    {
        $this->external_id = $external_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     * @return SubscriptionCompany
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     * @return SubscriptionCompany
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}
