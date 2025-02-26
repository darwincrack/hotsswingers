<?php

namespace PaylandsSDK\Types;

/**
 * Class TransactionOrder
 */
class TransactionOrder
{
    /**
     * @var string
     */
    private $transactionUUID;
    /**
     * @var string
     */
    private $orderUUID;
    /**
     * @var string
     */
    private $clientUUID;
    /**
     * @var string|null
     */
    private $customerExtId;
    /**
     * @var string
     */
    private $sourceType;
    /**
     * @var string
     */
    private $holder;
    /**
     * @var string
     */
    private $country;
    /**
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $pan;
    /**
     * @var string
     */
    private $bank;
    /**
     * @var string
     */
    private $created;
    /**
     * @var float
     */
    private $amount;
    /**
     * @var string
     */
    private $processorID;
    /**
     * @var string
     */
    private $status;
    /**
     * @var string
     */
    private $error;
    /**
     * @var string
     */
    private $authorization;
    /**
     * @var string
     */
    private $serviceUUID;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string|null
     */
    private $ip;
    /**
     * @var string|null
     */
    private $additional;
    /**
     * @var string
     */
    private $terminal;
    /**
     * @var string|null
     */
    private $sourcePrepaid;
    /**
     * @var string
     */
    private $currency;
    /**
     * @var string|null
     */
    private $sourceAdditional;

    /**
     * TransactionOrder constructor.
     * @param string $transactionUUID
     * @param string $orderUUID
     * @param string $clientUUID
     * @param string|null $customerExtId
     * @param string $sourceType
     * @param string $holder
     * @param string $country
     * @param string $token
     * @param string $pan
     * @param string $bank
     * @param string $created
     * @param float $amount
     * @param string $processorID
     * @param string $status
     * @param string $error
     * @param string $authorization
     * @param string $serviceUUID
     * @param string $type
     * @param string|null $ip
     * @param string|null $additional
     * @param string $terminal
     * @param string|null $sourceAdditional
     * @param string|null $sourcePrepaid
     * @param string $currency
     */
    public function __construct(
        $transactionUUID,
        $orderUUID,
        $clientUUID,
        $customerExtId,
        $sourceType,
        $holder,
        $country,
        $token,
        $pan,
        $bank,
        $created,
        $amount,
        $processorID,
        $status,
        $error,
        $authorization,
        $serviceUUID,
        $type,
        $ip,
        $additional,
        $terminal,
        $sourceAdditional,
        $sourcePrepaid,
        $currency
    ) {
        $this->transactionUUID = $transactionUUID;
        $this->orderUUID = $orderUUID;
        $this->clientUUID = $clientUUID;
        $this->customerExtId = $customerExtId;
        $this->sourceType = $sourceType;
        $this->holder = $holder;
        $this->country = $country;
        $this->token = $token;
        $this->pan = $pan;
        $this->bank = $bank;
        $this->created = $created;
        $this->amount = $amount;
        $this->processorID = $processorID;
        $this->status = $status;
        $this->error = $error;
        $this->authorization = $authorization;
        $this->serviceUUID = $serviceUUID;
        $this->type = $type;
        $this->ip = $ip;
        $this->additional = $additional;
        $this->terminal = $terminal;
        $this->sourcePrepaid = $sourcePrepaid;
        $this->currency = $currency;
        $this->sourceAdditional = $sourceAdditional;
    }

    /**
     * @return string
     */
    public function getTransactionUUID()
    {
        return $this->transactionUUID;
    }

    /**
     * @param string $transactionUUID
     * @return TransactionOrder
     */
    public function setTransactionUUID(string $transactionUUID): TransactionOrder
    {
        $this->transactionUUID = $transactionUUID;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderUUID()
    {
        return $this->orderUUID;
    }

    /**
     * @param string $orderUUID
     * @return TransactionOrder
     */
    public function setOrderUUID(string $orderUUID): TransactionOrder
    {
        $this->orderUUID = $orderUUID;
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
     * @return TransactionOrder
     */
    public function setClientUUID(string $clientUUID): TransactionOrder
    {
        $this->clientUUID = $clientUUID;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerExtId()
    {
        return $this->customerExtId;
    }

    /**
     * @param string $customerExtId
     * @return TransactionOrder
     */
    public function setCustomerExtId(string $customerExtId): TransactionOrder
    {
        $this->customerExtId = $customerExtId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceType()
    {
        return $this->sourceType;
    }

    /**
     * @param string $sourceType
     * @return TransactionOrder
     */
    public function setSourceType(string $sourceType): TransactionOrder
    {
        $this->sourceType = $sourceType;
        return $this;
    }

    /**
     * @return string
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * @param string $holder
     * @return TransactionOrder
     */
    public function setHolder(string $holder): TransactionOrder
    {
        $this->holder = $holder;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return TransactionOrder
     */
    public function setCountry(string $country): TransactionOrder
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return TransactionOrder
     */
    public function setToken(string $token): TransactionOrder
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * @param string $pan
     * @return TransactionOrder
     */
    public function setPan(string $pan): TransactionOrder
    {
        $this->pan = $pan;
        return $this;
    }

    /**
     * @return string
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param string $bank
     * @return TransactionOrder
     */
    public function setBank(string $bank): TransactionOrder
    {
        $this->bank = $bank;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $created
     * @return TransactionOrder
     */
    public function setCreated(string $created): TransactionOrder
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return TransactionOrder
     */
    public function setAmount(float $amount): TransactionOrder
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getProcessorID()
    {
        return $this->processorID;
    }

    /**
     * @param string $processorID
     * @return TransactionOrder
     */
    public function setProcessorID(string $processorID): TransactionOrder
    {
        $this->processorID = $processorID;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return TransactionOrder
     */
    public function setStatus(string $status): TransactionOrder
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     * @return TransactionOrder
     */
    public function setError(string $error): TransactionOrder
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param string $authorization
     * @return TransactionOrder
     */
    public function setAuthorization(string $authorization): TransactionOrder
    {
        $this->authorization = $authorization;
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
     * @return TransactionOrder
     */
    public function setServiceUUID(string $serviceUUID): TransactionOrder
    {
        $this->serviceUUID = $serviceUUID;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return TransactionOrder
     */
    public function setType(string $type): TransactionOrder
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return TransactionOrder
     */
    public function setIp(string $ip): TransactionOrder
    {
        $this->ip = $ip;
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
     * @return TransactionOrder
     */
    public function setAdditional(string $additional): TransactionOrder
    {
        $this->additional = $additional;
        return $this;
    }

    /**
     * @return string
     */
    public function getTerminal()
    {
        return $this->terminal;
    }

    /**
     * @param string $terminal
     * @return TransactionOrder
     */
    public function setTerminal(string $terminal): TransactionOrder
    {
        $this->terminal = $terminal;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSourcePrepaid()
    {
        return $this->sourcePrepaid;
    }

    /**
     * @param string $sourcePrepaid
     * @return TransactionOrder
     */
    public function setSourcePrepaid(string $sourcePrepaid): TransactionOrder
    {
        $this->sourcePrepaid = $sourcePrepaid;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return TransactionOrder
     */
    public function setCurrency(string $currency): TransactionOrder
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSourceAdditional()
    {
        return $this->sourceAdditional;
    }

    /**
     * @param string $sourceAdditional
     * @return TransactionOrder
     */
    public function setSourceAdditional(string $sourceAdditional): TransactionOrder
    {
        $this->sourceAdditional = $sourceAdditional;
        return $this;
    }
}
