<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\BatchError;

class SendPaymentFileResponse extends BaseResponse
{
    /**
     * @var BatchError[]
     */
    private $errors = [];

    public function __construct(string $message, int $code, string $current_time, array $errors = [])
    {
        parent::__construct($message, $code, $current_time);
        $this->errors = $errors;
    }

    /**
     * @return BatchError[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
