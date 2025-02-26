<?php


namespace PaylandsSDK\Responses;

use PaylandsSDK\Types\SubscriptionCompany;

/**
 * Class CreateSubscriptionCompanyResponse
 * @package PaylandsSDK\Responses
 */
class CreateSubscriptionCompanyResponse extends BaseResponse
{
    /**
     * @var SubscriptionCompany
     */
    private $company;

    /**
     * CreateSubscriptionCompanyResponse constructor.
     * @param string $message
     * @param int $code
     * @param string $current_time
     * @param SubscriptionCompany $company
     */
    public function __construct(string $message, int $code, string $current_time, SubscriptionCompany $company)
    {
        parent::__construct($message, $code, $current_time);
        $this->company = $company;
    }

    /**
     * @return SubscriptionCompany
     */
    public function getCompany()
    {
        return $this->company;
    }
}
