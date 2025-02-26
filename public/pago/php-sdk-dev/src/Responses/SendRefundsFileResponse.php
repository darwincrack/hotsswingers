<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\BatchError;

class SendRefundsFileResponse extends BaseResponse
{
    /**
     * @var BatchError[]
     */
    private $errors = [];

    /**
     * SendRefundsFileResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param array $errors
     */
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
