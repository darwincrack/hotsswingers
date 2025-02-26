<?php


namespace PaylandsSDK\Requests;

/**
 * Class SaveCardRequest
 * @package PaylandsSDK\Requests
 */
class SaveCardRequest
{
    /**
     * @var string
     */
    private $customer_ext_id;
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
     * @var string
     */
    private $card_cvv;
    /**
     * @var bool
     */
    private $validate;
    /**
     * @var string
     */
    private $service;
    /**
     * @var string|null
     */
    private $additional;
    /**
     * @var string|null
     */
    private $url_post;

    /**
     * SaveCardRequest constructor.
     * @param string $customer_ext_id
     * @param string $card_holder
     * @param string $card_pan
     * @param string $card_expiry_year
     * @param string $card_expiry_month
     * @param string $card_cvv
     * @param bool $validate
     * @param string $service
     * @param string|null $additional
     * @param string|null $url_post
     */
    public function __construct(
        string $customer_ext_id,
        string $card_holder,
        string $card_pan,
        string $card_expiry_year,
        string $card_expiry_month,
        string $card_cvv,
        bool $validate,
        string $service,
        string $additional = null,
        string $url_post = null
    ) {
        $this->customer_ext_id = $customer_ext_id;
        $this->card_holder = $card_holder;
        $this->card_pan = $card_pan;
        $this->card_expiry_year = $card_expiry_year;
        $this->card_expiry_month = $card_expiry_month;
        $this->card_cvv = $card_cvv;
        $this->validate = $validate;
        $this->service = $service;
        $this->additional = $additional;
        $this->url_post = $url_post;
    }

    public function parseRequest(): array
    {
        return [
            "customer_ext_id" => $this->customer_ext_id,
            "card_holder" => $this->card_holder,
            "card_pan" => $this->card_pan,
            "card_expiry_year" => $this->card_expiry_year,
            "card_expiry_month" => $this->card_expiry_month,
            "card_cvv" => $this->card_cvv,
            "additional" => $this->additional,
            "url_post" => $this->url_post,
            "validate" => $this->validate,
            "service" => $this->service
        ];
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
     * @return SaveCardRequest
     */
    public function setCustomerExtId(string $customer_ext_id): SaveCardRequest
    {
        $this->customer_ext_id = $customer_ext_id;
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
     * @return SaveCardRequest
     */
    public function setCardHolder(string $card_holder): SaveCardRequest
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
     * @return SaveCardRequest
     */
    public function setCardPan(string $card_pan): SaveCardRequest
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
     * @return SaveCardRequest
     */
    public function setCardExpiryYear(string $card_expiry_year): SaveCardRequest
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
     * @return SaveCardRequest
     */
    public function setCardExpiryMonth(string $card_expiry_month): SaveCardRequest
    {
        $this->card_expiry_month = $card_expiry_month;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardCvv()
    {
        return $this->card_cvv;
    }

    /**
     * @param string $card_cvv
     * @return SaveCardRequest
     */
    public function setCardCvv(string $card_cvv): SaveCardRequest
    {
        $this->card_cvv = $card_cvv;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValidate()
    {
        return $this->validate;
    }

    /**
     * @param bool $validate
     * @return SaveCardRequest
     */
    public function setValidate(bool $validate): SaveCardRequest
    {
        $this->validate = $validate;
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
     * @return SaveCardRequest
     */
    public function setService(string $service): SaveCardRequest
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * @param string $additional
     * @return SaveCardRequest
     */
    public function setAdditional(string $additional): SaveCardRequest
    {
        $this->additional = $additional;
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
     * @return SaveCardRequest
     */
    public function setUrlPost(string $url_post): SaveCardRequest
    {
        $this->url_post = $url_post;
        return $this;
    }
}
