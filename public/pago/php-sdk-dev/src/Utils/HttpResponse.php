<?php

declare(strict_types=1);

namespace PaylandsSDK\Utils;

class HttpResponse
{
    /**
     * @var string[][]
     */
    private $headers;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $content;

    /**
     * HttpResponse constructor.
     * @param array $headers
     * @param int $statusCode
     * @param string $content
     */
    public function __construct(array $headers, int $statusCode, string $content)
    {
        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }
}
