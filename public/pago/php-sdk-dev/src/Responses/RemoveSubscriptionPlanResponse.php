<?php


namespace PaylandsSDK\Responses;

class RemoveSubscriptionPlanResponse extends BaseResponse
{
    /**
     * @var int
     */
    private $deleted;

    /**
     * RemoveSubscriptionPlanResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param int $deleted
     */
    public function __construct(string $message, int $code, string $current_time, int $deleted)
    {
        parent::__construct($message, $code, $current_time);
        $this->deleted = $deleted;
    }

    /**
     * @return int
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
