<?php


namespace PaylandsSDK\Requests;

class SubscribeCustomerRequest
{
    /**
     * @var string
     */
    private $customer;
    /**
     * @var string
     */
    private $plan;
    /**
     * @var int
     */
    private $total_payment_number;
    /**
     * @var int
     */
    private $payment_attempts_limit;
    /**
     * @var string|null
     */
    private $initial_date;
    /**
     * @var SubscriptionAdditionalData|null
     */
    private $additional_data;

    /**
     * SubscribeCustomerRequest constructor.
     * @param string $customer
     * @param string $plan
     * @param int $total_payment_number
     * @param int $payment_attempts_limit
     * @param string $initial_date
     * @param SubscriptionAdditionalData $additional_data
     */
    public function __construct(
        string $customer,
        string $plan,
        int $total_payment_number,
        int $payment_attempts_limit,
        string $initial_date = null,
        SubscriptionAdditionalData $additional_data = null
    ) {
        $this->customer = $customer;
        $this->plan = $plan;
        $this->total_payment_number = $total_payment_number;
        $this->payment_attempts_limit = $payment_attempts_limit;
        $this->initial_date = $initial_date;
        $this->additional_data = $additional_data;
    }

    public function parseRequest(): array
    {
        return [
            "customer" => $this->customer,
            "plan" => $this->plan,
            "total_payment_number" => $this->total_payment_number,
            "payment_attempts_limit" => $this->payment_attempts_limit,
            "initial_date" => $this->initial_date,
            "additional_data" => $this->additional_data
        ];
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     * @return SubscribeCustomerRequest
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param mixed $plan
     * @return SubscribeCustomerRequest
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPaymentNumber()
    {
        return $this->total_payment_number;
    }

    /**
     * @param mixed $total_payment_number
     * @return SubscribeCustomerRequest
     */
    public function setTotalPaymentNumber($total_payment_number)
    {
        $this->total_payment_number = $total_payment_number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentAttemptsLimit()
    {
        return $this->payment_attempts_limit;
    }

    /**
     * @param mixed $payment_attempts_limit
     * @return SubscribeCustomerRequest
     */
    public function setPaymentAttemptsLimit($payment_attempts_limit)
    {
        $this->payment_attempts_limit = $payment_attempts_limit;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInitialDate()
    {
        return $this->initial_date;
    }

    /**
     * @param null $initial_date
     * @return SubscribeCustomerRequest
     */
    public function setInitialDate($initial_date)
    {
        $this->initial_date = $initial_date;
        return $this;
    }

    /**
     * @return SubscriptionAdditionalData|null
     */
    public function getAdditionalData()
    {
        return $this->additional_data;
    }

    /**
     * @param SubscriptionAdditionalData $additional_data
     * @return SubscribeCustomerRequest
     */
    public function setAdditionalData(SubscriptionAdditionalData $additional_data): SubscribeCustomerRequest
    {
        $this->additional_data = $additional_data;
        return $this;
    }
}
