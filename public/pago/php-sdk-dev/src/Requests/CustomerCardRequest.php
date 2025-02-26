<?php


namespace PaylandsSDK\Requests;

/**
 * Class CustomerCardRequest
 * @package PaylandsSDK\Types
 */
class CustomerCardRequest
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
     * @var string|null
     */
    private $additional;
    /**
     * @var string|null
     */
    private $url_post;

    /**
     * CustomerCardRequest constructor.
     * @param string $customer_ext_id
     * @param string $card_holder
     * @param string $card_pan
     * @param string $card_expiry_year
     * @param string $card_expiry_month
     * @param string $card_cvv
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
        string $url_post = null,
        string $additional = null
    ) {
        $this->customer_ext_id = $customer_ext_id;
        $this->card_holder = $card_holder;
        $this->card_pan = $card_pan;
        $this->card_expiry_year = $card_expiry_year;
        $this->card_expiry_month = $card_expiry_month;
        $this->card_cvv = $card_cvv;
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
     * @return CustomerCardRequest
     */
    public function setCustomerExtId(string $customer_ext_id): CustomerCardRequest
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
     * @return CustomerCardRequest
     */
    public function setCardHolder(string $card_holder): CustomerCardRequest
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
     * @return CustomerCardRequest
     */
    public function setCardPan(string $card_pan): CustomerCardRequest
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
     * @return CustomerCardRequest
     */
    public function setCardExpiryYear(string $card_expiry_year): CustomerCardRequest
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
     * @return CustomerCardRequest
     */
    public function setCardExpiryMonth(string $card_expiry_month): CustomerCardRequest
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
     * @return CustomerCardRequest
     */
    public function setCardCvv(string $card_cvv): CustomerCardRequest
    {
        $this->card_cvv = $card_cvv;
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
     * @return CustomerCardRequest
     */
    public function setAdditional(string $additional): CustomerCardRequest
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
     * @return CustomerCardRequest
     */
    public function setUrlPost(string $url_post): CustomerCardRequest
    {
        $this->url_post = $url_post;
        return $this;
    }
}
