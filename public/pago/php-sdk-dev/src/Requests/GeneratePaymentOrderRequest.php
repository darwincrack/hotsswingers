<?php


namespace PaylandsSDK\Requests;

use PaylandsSDK\Types\Enums\Operative;

/**
 * Class GeneratePaymentOrderRequest
 * @package PaylandsSDK\Requests
 */
class GeneratePaymentOrderRequest
{
    /**
     * @var integer
     */
    private $amount;
    /**
     * @var Operative
     */
    private $operative;
    /**
     * @var string|null
     */
    private $customer_ext_id;
    /**
     * @var string|null
     */
    private $additional;
    /**
     * @var string
     */
    private $service;
    /**
     * @var boolean|null
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
     * @var string|null
     */
    private $source_uuid;

    /**
     * @var PaymentOrderExtraData|null
     */
    private $extra_data = null;

    /**
     * @var string|null
     */
    private $dcc_template_uuid;

    /**
     * GeneratePaymentOrderRequest constructor.
     * @param int $amount
     * @param Operative $operative
     * @param string $customer_ext_id
     * @param string $additional
     * @param string $service
     * @param bool|null $secure
     * @param string $url_post
     * @param string $url_ok
     * @param string $url_ko
     * @param string $description
     * @param string $source_uuid
     * @param string $template_uuid
     * @param string $dcc_template_uuid
     * @param PaymentOrderExtraData|null $extra_data
     */
    public function __construct(
        int $amount,
        Operative $operative,
        string $customer_ext_id,
        string $service,
        string $description,
        string $additional = null,
        bool $secure = null,
        string $url_post = null,
        string $url_ok = null,
        string $url_ko = null,
        string $source_uuid = null,
        string $template_uuid = null,
        string $dcc_template_uuid = null,
        PaymentOrderExtraData $extra_data = null
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
        $this->source_uuid = $source_uuid;
        $this->extra_data = $extra_data;
        $this->dcc_template_uuid = $dcc_template_uuid;
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
          "dcc_template_uuid" => $this->dcc_template_uuid,
          "description" => $this->description,
          "source_uuid" => $this->source_uuid,
          "extra_data" => is_null($this->extra_data) ? null : [
              "payment" => [
                  "installments" => $this->extra_data->getPayment()->getInstallments()
              ]
          ],
        ];
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return GeneratePaymentOrderRequest
     */
    public function setAmount(int $amount): GeneratePaymentOrderRequest
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
     * @return GeneratePaymentOrderRequest
     */
    public function setOperative(Operative $operative): GeneratePaymentOrderRequest
    {
        $this->operative = $operative;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerExtId()
    {
        return $this->customer_ext_id;
    }

    /**
     * @param string $customer_ext_id
     * @return GeneratePaymentOrderRequest
     */
    public function setCustomerExtId(string $customer_ext_id): GeneratePaymentOrderRequest
    {
        $this->customer_ext_id = $customer_ext_id;
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
     * @return GeneratePaymentOrderRequest
     */
    public function setAdditional(string $additional): GeneratePaymentOrderRequest
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
     * @return GeneratePaymentOrderRequest
     */
    public function setService(string $service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure ?? false;
    }

    /**
     * @param bool $secure
     * @return GeneratePaymentOrderRequest
     */
    public function setSecure(bool $secure): GeneratePaymentOrderRequest
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
     * @return GeneratePaymentOrderRequest
     */
    public function setUrlPost(string $url_post): GeneratePaymentOrderRequest
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
     * @return GeneratePaymentOrderRequest
     */
    public function setUrlOk(string $url_ok): GeneratePaymentOrderRequest
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
     * @return GeneratePaymentOrderRequest
     */
    public function setUrlKo(string $url_ko): GeneratePaymentOrderRequest
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
     * @return GeneratePaymentOrderRequest
     */
    public function setTemplateUuid(string $template_uuid): GeneratePaymentOrderRequest
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
     * @return GeneratePaymentOrderRequest
     */
    public function setDescription(string $description): GeneratePaymentOrderRequest
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSourceUuid()
    {
        return $this->source_uuid;
    }

    /**
     * @param string $source_uuid
     * @return GeneratePaymentOrderRequest
     */
    public function setSourceUuid(string $source_uuid): GeneratePaymentOrderRequest
    {
        $this->source_uuid = $source_uuid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtraData()
    {
        return $this->extra_data;
    }

    /**
     * @param mixed $extra_data
     * @return GeneratePaymentOrderRequest
     */
    public function setExtraData($extra_data)
    {
        $this->extra_data = $extra_data;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDccTemplateUuid()
    {
        return $this->dcc_template_uuid;
    }

    /**
     * @param string $dcc_template_uuid
     * @return GeneratePaymentOrderRequest
     */
    public function setDccTemplateUuid(string $dcc_template_uuid): GeneratePaymentOrderRequest
    {
        $this->dcc_template_uuid = $dcc_template_uuid;
        return $this;
    }
}
