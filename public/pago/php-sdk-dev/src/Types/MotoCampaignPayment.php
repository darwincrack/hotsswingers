<?php

namespace PaylandsSDK\Types;

use PaylandsSDK\Types\Enums\MoToCampaignStatus;
use PaylandsSDK\Types\Enums\Operative;

/**
 * Class MotoCampaignPayment
 */
class MotoCampaignPayment
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var integer
     */
    private $detailUUID;
    /**
     * @var integer
     */
    private $line;
    /**
     * @var MoToCampaignStatus
     */
    private $status;
    /**
     * @var integer
     */
    private $amount;
    /**
     * @var Operative
     */
    private $operative;
    /**
     * @var boolean
     */
    private $secure;
    /**
     * @var string
     */
    private $destination;
    /**
     * @var string
     */
    private $createdAt;
    /**
     * @var string|null
     */
    private $externalID;
    /**
     * @var string|null
     */
    private $additional;
    /**
     * @var string
     */
    private $urlPost;
    /**
     * @var string
     */
    private $urlOk;
    /**
     * @var string
     */
    private $urlKo;
    /**
     * @var string|null
     */
    private $cardTemplate;
    /**
     * @var string|null
     */
    private $dccTemplate;
    /**
     * @var string|null
     */
    private $moToTemplate;

    /**
     * MotoCampaignPayment constructor.
     * @param int $id
     * @param string $uuid
     * @param int $detailUUID
     * @param int $line
     * @param MoToCampaignStatus $status
     * @param int $amount
     * @param Operative $operative
     * @param bool $secure
     * @param string $destination
     * @param string $createdAt
     * @param string|null $externalID
     * @param string|null $additional
     * @param string $urlPost
     * @param string $urlOk
     * @param string $urlKo
     * @param string $cardTemplate
     * @param string|null $dccTemplate
     * @param string|null $moToTemplate
     */
    public function __construct(
        int $id,
        string $uuid,
        int $detailUUID,
        int $line,
        MoToCampaignStatus $status,
        int $amount,
        Operative $operative,
        bool $secure,
        string $destination,
        string $createdAt,
        string $urlPost,
        string $urlOk,
        string $urlKo,
        string $externalID = null,
        string $additional = null,
        string $cardTemplate = null,
        string $dccTemplate = null,
        string $moToTemplate = null
    ) {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->detailUUID = $detailUUID;
        $this->line = $line;
        $this->status = $status;
        $this->amount = $amount;
        $this->operative = $operative;
        $this->secure = $secure;
        $this->destination = $destination;
        $this->createdAt = $createdAt;
        $this->externalID = $externalID;
        $this->additional = $additional;
        $this->urlPost = $urlPost;
        $this->urlOk = $urlOk;
        $this->urlKo = $urlKo;
        $this->cardTemplate = $cardTemplate;
        $this->dccTemplate = $dccTemplate;
        $this->moToTemplate = $moToTemplate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return MotoCampaignPayment
     */
    public function setId(int $id): MotoCampaignPayment
    {
        $this->id = $id;
        return $this;
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
     * @return MotoCampaignPayment
     */
    public function setUuid(string $uuid): MotoCampaignPayment
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return int
     */
    public function getDetailUUID()
    {
        return $this->detailUUID;
    }

    /**
     * @param int $detailUUID
     * @return MotoCampaignPayment
     */
    public function setDetailUUID(int $detailUUID): MotoCampaignPayment
    {
        $this->detailUUID = $detailUUID;
        return $this;
    }

    /**
     * @return int
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param int $line
     * @return MotoCampaignPayment
     */
    public function setLine(int $line): MotoCampaignPayment
    {
        $this->line = $line;
        return $this;
    }

    /**
     * @return MoToCampaignStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param MoToCampaignStatus $status
     * @return MotoCampaignPayment
     */
    public function setStatus(MoToCampaignStatus $status): MotoCampaignPayment
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return MotoCampaignPayment
     */
    public function setAmount(int $amount): MotoCampaignPayment
    {
        $this->amount = $amount;
        return $this;
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
     * @return MotoCampaignPayment
     */
    public function setOperative(Operative $operative): MotoCampaignPayment
    {
        $this->operative = $operative;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * @param bool $secure
     * @return MotoCampaignPayment
     */
    public function setSecure(bool $secure): MotoCampaignPayment
    {
        $this->secure = $secure;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     * @return MotoCampaignPayment
     */
    public function setDestination(string $destination): MotoCampaignPayment
    {
        $this->destination = $destination;
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
     * @return MotoCampaignPayment
     */
    public function setCreatedAt(string $createdAt): MotoCampaignPayment
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalID()
    {
        return $this->externalID;
    }

    /**
     * @param string $externalID
     * @return MotoCampaignPayment
     */
    public function setExternalID(string $externalID): MotoCampaignPayment
    {
        $this->externalID = $externalID;
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
     * @return MotoCampaignPayment
     */
    public function setAdditional(string $additional): MotoCampaignPayment
    {
        $this->additional = $additional;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlPost()
    {
        return $this->urlPost;
    }

    /**
     * @param string $urlPost
     * @return MotoCampaignPayment
     */
    public function setUrlPost(string $urlPost): MotoCampaignPayment
    {
        $this->urlPost = $urlPost;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlOk()
    {
        return $this->urlOk;
    }

    /**
     * @param string $urlOk
     * @return MotoCampaignPayment
     */
    public function setUrlOk(string $urlOk): MotoCampaignPayment
    {
        $this->urlOk = $urlOk;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlKo()
    {
        return $this->urlKo;
    }

    /**
     * @param string $urlKo
     * @return MotoCampaignPayment
     */
    public function setUrlKo(string $urlKo): MotoCampaignPayment
    {
        $this->urlKo = $urlKo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardTemplate()
    {
        return $this->cardTemplate;
    }

    /**
     * @param string $cardTemplate
     * @return MotoCampaignPayment
     */
    public function setCardTemplate(string $cardTemplate): MotoCampaignPayment
    {
        $this->cardTemplate = $cardTemplate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDccTemplate()
    {
        return $this->dccTemplate;
    }

    /**
     * @param string $dccTemplate
     * @return MotoCampaignPayment
     */
    public function setDccTemplate(string $dccTemplate): MotoCampaignPayment
    {
        $this->dccTemplate = $dccTemplate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMoToTemplate()
    {
        return $this->moToTemplate;
    }

    /**
     * @param string $moToTemplate
     * @return MotoCampaignPayment
     */
    public function setMoToTemplate(string $moToTemplate): MotoCampaignPayment
    {
        $this->moToTemplate = $moToTemplate;
        return $this;
    }
}
