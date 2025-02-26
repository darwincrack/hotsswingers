<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\CampaignDetail;
use PaylandsSDK\Types\MotoCampaignPayment;

class CreateMotoCampaignResponse extends BaseResponse
{
    /**
     * @var CampaignDetail
     */
    private $detail;
    /**
     * @var MotoCampaignPayment[]
     */
    private $payments = [];

    /**
     * CreateMotoCampaignResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param CampaignDetail $detail
     * @param array $payments
     */
    public function __construct(string $message, int $code, string $current_time, CampaignDetail $detail, array $payments)
    {
        parent::__construct($message, $code, $current_time);
        $this->detail = $detail;
        $this->payments = $payments;
    }

    /**
     * @return CampaignDetail
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @return array
     */
    public function getPayments()
    {
        return $this->payments;
    }
}
