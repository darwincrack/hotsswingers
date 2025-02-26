<?php


namespace PaylandsSDK\Requests;

class SendRefundsFileRequest
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
     * @var string|null
     */
    private $execute_at;

    /**
     * SendRefundsFileRequest constructor.
     * @param string $filename
     * @param string $data
     * @param string|null $execute_at
     */
    public function __construct(string $filename, string $data, string $execute_at = null)
    {
        $this->filename = $filename;
        $this->data = $data;
        $this->execute_at = $execute_at;
    }

    public function parseRequest(): array
    {
        return [
            "filename" => $this->filename,
            "data" => $this->data,
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
     * @return SendRefundsFileRequest
     */
    public function setFilename(string $filename): SendRefundsFileRequest
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
     * @return SendRefundsFileRequest
     */
    public function setData(string $data): SendRefundsFileRequest
    {
        $this->data = $data;
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
     * @return SendRefundsFileRequest
     */
    public function setExecuteAt(string $execute_at): SendRefundsFileRequest
    {
        $this->execute_at = $execute_at;
        return $this;
    }
}
