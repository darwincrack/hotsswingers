<?php


namespace PaylandsSDK\Requests;

/**
 * Class SendPaymentFileRequest
 * @package PaylandsSDK\Requests
 */
class SendPaymentFileRequest
{
    /**
     * @var string
     */
    private $filename;
    /**
     * @var string
     */
    private $data;
    /**
     * @var string
     */
    private $service;
    /**
     * @var string|null
     */
    private $execute_at;

    /**
     * SendPaymentFileRequest constructor.
     * @param string $filename
     * @param string $data
     * @param string $service
     * @param string|null $execute_at
     */
    public function __construct(string $filename, string $data, string $service, string $execute_at = null)
    {
        $this->filename = $filename;
        $this->data = $data;
        $this->service = $service;
        $this->execute_at = $execute_at;
    }

    public function parseRequest(): array
    {
        return [
            "filename" => $this->filename,
            "data" => $this->data,
            "service" => $this->service,
            "execute_at" => $this->execute_at,
        ];
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
     * @return SendPaymentFileRequest
     */
    public function setFilename(string $filename): SendPaymentFileRequest
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return SendPaymentFileRequest
     */
    public function setData(string $data): SendPaymentFileRequest
    {
        $this->data = $data;
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
     * @return SendPaymentFileRequest
     */
    public function setService(string $service): SendPaymentFileRequest
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExecuteAt()
    {
        return $this->execute_at;
    }

    /**
     * @param string $execute_at
     * @return SendPaymentFileRequest
     */
    public function setExecuteAt(string $execute_at): SendPaymentFileRequest
    {
        $this->execute_at = $execute_at;
        return $this;
    }
}
