<?php

declare(strict_types=1);

namespace PaylandsSDK\Exceptions;

use PaylandsSDK\Types\ErrorResponse;
use RuntimeException;

class PaylandsClientException extends RuntimeException
{
    /**
     * @var ErrorResponse
     */
    private $errorResponse;

    public function __construct(ErrorResponse $errorResponse)
    {
        parent::__construct($errorResponse->getMessage(), $errorResponse->getCode(), null);
        $this->errorResponse = $errorResponse;
    }

    /**
     * @return ErrorResponse
     */
    public function getErrorResponse()
    {
        return $this->errorResponse;
    }
}
