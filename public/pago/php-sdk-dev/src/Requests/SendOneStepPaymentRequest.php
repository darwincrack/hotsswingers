<?php


namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\Operative;

/**
 * Class SendOneStepPaymentRequest
 * @package PaylandsSDK\Requests
 */
class SendOneStepPaymentRequest
{
    /**
     * @var float
     */
    private $amount;
    /**
     * @var Operative
     */
    private $operative;
    /**
     * @var string
     */
    private $customer_ext_id;
    /**
     * @var string
     */
    private $additional;
    /**
     * @var string
     */
    private $service;
    /**
     * @var boolean
     */
    private $secure;
    /**
     * @var string|null
     */
    private $url_post;
    /**
     * @var string|null
     */
    private $url_ok;
    /**
     * @var string|null
     */
    private $url_ko;
    /**
     * @var string|null
     */
    private $template_uuid;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $card_holder;
    /**
     * @var string
     */
    private $card_pan;
    /**
     * @var string
     */
    private $card_expiry_year;
    /**
     * @var string
     */
    private $card_expiry_month;
    /**
     * @var string|null
     */
    private $card_additional;
    /**
     * @var string|null
     */
    private $card_cvv;
    /**
     * @var string|null
     */
    private $customer_ip;

    /**
     * SendOneStepPaymentRequest constructor.
     * @param float $amount
     * @param Operative $operative
     * @param string $customer_ext_id
     * @param string $additional
     * @param string $service
     * @param bool $secure
     * @param string|null $url_post
     * @param string|null $url_ok
     * @param string|null $url_ko
     * @param string|null $template_uuid
     * @param string $description
     * @param string $card_holder
     * @param string $card_pan
     * @param string $card_expiry_year
     * @param string $card_expiry_month
     * @param string|null $card_additional
     * @param string|null $card_cvv
     * @param string|null $customer_ip
     */
    public function __construct(
        float $amount,
        Operative $operative,
        string $customer_ext_id,
        string $additional,
        string $service,
        bool $secure,
        string $description,
        string $card_holder,
        string $card_pan,
        string $card_expiry_year,
        string $card_expiry_month,
        string $url_post = null,
        string $url_ok = null,
        string $url_ko = null,
        string $template_uuid = null,
        string $card_additional = null,
        string $card_cvv = null,
        string $customer_ip = null
    ) {
        $this->amount = $amount;
        $this->operative = $operative;
        $this->customer_ext_id = $customer_ext_id;
        $this->additional = $additional;
        $this->service = $service;
        $this->secure = $secure;
        $this->url_post = $url_post;
        $this->url_ok = $url_ok;
        $this->url_ko = $url_ko;
        $this->template_uuid = $template_uuid;
        $this->description = $description;
        $this->card_holder = $card_holder;
        $this->card_pan = $card_pan;
        $this->card_expiry_year = $card_expiry_year;
        $this->card_expiry_month = $card_expiry_month;
        $this->card_additional = $card_additional;
        $this->card_cvv = $card_cvv;
        $this->customer_ip = $customer_ip;
    }

    public function parseRequest(): array
    {
        return [
            "amount" => $this->amount,
            "operative" => $this->operative->getValue(),
            "customer_ext_id" => $this->customer_ext_id,
            "additional" => $this->additional,
            "service" => $this->service,
            "secure" => $this->secure,
            "url_post" => $this->url_post,
            "url_ok" => $this->url_ok,
            "url_ko" => $this->url_ko,
            "template_uuid" => $this->template_uuid,
            "description" => $this->description,
            "card_holder" => $this->card_holder,
            "card_pan" => $this->card_pan,
            "card_expiry_month" => $this->card_expiry_month,
            "card_expiry_year" => $this->card_expiry_year,
            "card_additional" => $this->card_additional,
            "card_cvv" => $this->card_cvv,
        ];
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return SendOneStepPaymentRequest
     */
    public function setAmount(float $amount): SendOneStepPaymentRequest
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return Operative
     */
    public function getOperative()
    {
        return $this->operative;
    }

    /**
     * @param Operative $operative
     * @return SendOneStepPaymentRequest
     */
    public function setOperative(Operative $operative): SendOneStepPaymentRequest
    {
        $this->operative = $operative;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerExtId()
    {
        return $this->customer_ext_id;
    }

    /**
     * @param string $customer_ext_id
     * @return SendOneStepPaymentRequest
     */
    public function setCustomerExtId(string $customer_ext_id): SendOneStepPaymentRequest
    {
        $this->customer_ext_id = $customer_ext_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * @param string $additional
     * @return SendOneStepPaymentRequest
     */
    public function setAdditional(string $additional): SendOneStepPaymentRequest
    {
        $this->additional = $additional;
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
     * @return SendOneStepPaymentRequest
     */
    public function setService(string $service): SendOneStepPaymentRequest
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * @param bool $secure
     * @return SendOneStepPaymentRequest
     */
    public function setSecure(bool $secure): SendOneStepPaymentRequest
    {
        $this->secure = $secure;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlPost()
    {
        return $this->url_post;
    }

    /**
     * @param string $url_post
     * @return SendOneStepPaymentRequest
     */
    public function setUrlPost(string $url_post): SendOneStepPaymentRequest
    {
        $this->url_post = $url_post;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlOk()
    {
        return $this->url_ok;
    }

    /**
     * @param string $url_ok
     * @return SendOneStepPaymentRequest
     */
    public function setUrlOk(string $url_ok): SendOneStepPaymentRequest
    {
        $this->url_ok = $url_ok;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlKo()
    {
        return $this->url_ko;
    }

    /**
     * @param string $url_ko
     * @return SendOneStepPaymentRequest
     */
    public function setUrlKo(string $url_ko): SendOneStepPaymentRequest
    {
        $this->url_ko = $url_ko;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTemplateUuid()
    {
        return $this->template_uuid;
    }

    /**
     * @param string $template_uuid
     * @return SendOneStepPaymentRequest
     */
    public function setTemplateUuid(string $template_uuid): SendOneStepPaymentRequest
    {
        $this->template_uuid = $template_uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return SendOneStepPaymentRequest
     */
    public function setDescription(string $description): SendOneStepPaymentRequest
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardHolder()
    {
        return $this->card_holder;
    }

    /**
     * @param string $card_holder
     * @return SendOneStepPaymentRequest
     */
    public function setCardHolder(string $card_holder): SendOneStepPaymentRequest
    {
        $this->card_holder = $card_holder;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardPan()
    {
        return $this->card_pan;
    }

    /**
     * @param string $card_pan
     * @return SendOneStepPaymentRequest
     */
    public function setCardPan(string $card_pan): SendOneStepPaymentRequest
    {
        $this->card_pan = $card_pan;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardExpiryYear()
    {
        return $this->card_expiry_year;
    }

    /**
     * @param string $card_expiry_year
     * @return SendOneStepPaymentRequest
     */
    public function setCardExpiryYear(string $card_expiry_year): SendOneStepPaymentRequest
    {
        $this->card_expiry_year = $card_expiry_year;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardExpiryMonth()
    {
        return $this->card_expiry_month;
    }

    /**
     * @param string $card_expiry_month
     * @return SendOneStepPaymentRequest
     */
    public function setCardExpiryMonth(string $card_expiry_month): SendOneStepPaymentRequest
    {
        $this->card_expiry_month = $card_expiry_month;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardAdditional()
    {
        return $this->card_additional;
    }

    /**
     * @param string $card_additional
     * @return SendOneStepPaymentRequest
     */
    public function setCardAdditional(string $card_additional): SendOneStepPaymentRequest
    {
        $this->card_additional = $card_additional;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardCvv()
    {
        return $this->card_cvv;
    }

    /**
     * @param string $card_cvv
     * @return SendOneStepPaymentRequest
     */
    public function setCardCvv(string $card_cvv): SendOneStepPaymentRequest
    {
        $this->card_cvv = $card_cvv;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerIp()
    {
        return $this->customer_ip;
    }

    /**
     * @param string $customer_ip
     * @return SendOneStepPaymentRequest
     */
    public function setCustomerIp(string $customer_ip): SendOneStepPaymentRequest
    {
        $this->customer_ip = $customer_ip;
        return $this;
    }
}
