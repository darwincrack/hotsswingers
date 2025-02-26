<?php

namespace PaylandsSDK;

use PaylandsSDK\Exceptions\PaylandsClientException;
use PaylandsSDK\Requests\CancelPaymentRequest;
use PaylandsSDK\Requests\ConfirmPaymentRequest;
use PaylandsSDK\Requests\CreateCustomerAccountRequest;
use PaylandsSDK\Requests\CreateCustomerAddressRequest;
use PaylandsSDK\Requests\CreateCustomerProfileRequest;
use PaylandsSDK\Requests\CreateCustomerRequest;
use PaylandsSDK\Requests\CreateMotoCampaignRequest;
use PaylandsSDK\Requests\CreateSubscriptionPlanRequest;
use PaylandsSDK\Requests\CreateSubscriptionProductRequest;
use PaylandsSDK\Requests\GeneratePaymentOrderRequest;
use PaylandsSDK\Requests\GetAccountTypeByAgentRequest;
use PaylandsSDK\Requests\GetBranchesRequest;
use PaylandsSDK\Requests\GetCardRequest;
use PaylandsSDK\Requests\GetCustomerAccountRequest;
use PaylandsSDK\Requests\GetCustomerAddressRequest;
use PaylandsSDK\Requests\GetCustomerCardsRequest;
use PaylandsSDK\Requests\GetCustomerProfileRequest;
use PaylandsSDK\Requests\GetOrderRequest;
use PaylandsSDK\Requests\GetOrdersRequest;
use PaylandsSDK\Requests\GetPaymentAgentsRequest;
use PaylandsSDK\Requests\GetPaymentTypeByAgentRequest;
use PaylandsSDK\Requests\GetProductsRequest;
use PaylandsSDK\Requests\GetRedirectPaymentURLRequest;
use PaylandsSDK\Requests\GetStatesRequest;
use PaylandsSDK\Requests\Payment;
use PaylandsSDK\Requests\PaymentOrderExtraData;
use PaylandsSDK\Requests\RefundRequest;
use PaylandsSDK\Requests\RemoveCardRequest;
use PaylandsSDK\Requests\RemoveCustomerAccountRequest;
use PaylandsSDK\Requests\RemoveCustomerAddressRequest;
use PaylandsSDK\Requests\RemoveSubscriptionPlanRequest;
use PaylandsSDK\Requests\RemoveSubscriptionProductRequest;
use PaylandsSDK\Requests\RemoveSubscriptionRequest;
use PaylandsSDK\Requests\SaveCardRequest;
use PaylandsSDK\Requests\SaveCardsRequest;
use PaylandsSDK\Requests\SendOneStepPaymentRequest;
use PaylandsSDK\Requests\SendPaymentFileRequest;
use PaylandsSDK\Requests\SendPayoutRequest;
use PaylandsSDK\Requests\SendRefundsFileRequest;
use PaylandsSDK\Requests\SendTokenizedPaymentRequest;
use PaylandsSDK\Requests\SendWSPaymentRequest;
use PaylandsSDK\Requests\SetCardDescriptionRequest;
use PaylandsSDK\Requests\SubscribeCustomerRequest;
use PaylandsSDK\Requests\UpdateCustomerAccountRequest;
use PaylandsSDK\Requests\UpdateCustomerAddressRequest;
use PaylandsSDK\Requests\UpdateCustomerProfileRequest;
use PaylandsSDK\Requests\ValidateTokenizedCardRequest;
use PaylandsSDK\Responses\CancelPaymentResponse;
use PaylandsSDK\Responses\ConfirmPaymentResponse;
use PaylandsSDK\Responses\CreateCustomerAccountResponse;
use PaylandsSDK\Responses\CreateCustomerAddressResponse;
use PaylandsSDK\Responses\CreateCustomerProfileResponse;
use PaylandsSDK\Responses\CreateCustomerResponse;
use PaylandsSDK\Responses\CreateMotoCampaignResponse;
use PaylandsSDK\Responses\CreateSubscriptionCompanyResponse;
use PaylandsSDK\Responses\CreateSubscriptionPlanResponse;
use PaylandsSDK\Responses\CreateSubscriptionProductResponse;
use PaylandsSDK\Responses\GeneratePaymentOrderResponse;
use PaylandsSDK\Responses\GetAccountTypeByAgentResponse;
use PaylandsSDK\Responses\GetApiKeyProfilesResponse;
use PaylandsSDK\Responses\GetBranchesResponse;
use PaylandsSDK\Responses\GetCardResponse;
use PaylandsSDK\Responses\GetCustomerAccountResponse;
use PaylandsSDK\Responses\GetCustomerAddressResponse;
use PaylandsSDK\Responses\GetCustomerCardsResponse;
use PaylandsSDK\Responses\GetCustomerProfileResponse;
use PaylandsSDK\Responses\GetMyApiKeyProfilesResponse;
use PaylandsSDK\Responses\GetOrderResponse;
use PaylandsSDK\Responses\GetOrdersResponse;
use PaylandsSDK\Responses\GetPaymentAgentsResponse;
use PaylandsSDK\Responses\GetPaymentTypeByAgentResponse;
use PaylandsSDK\Responses\GetProductsResponse;
use PaylandsSDK\Responses\GetStatesResponse;
use PaylandsSDK\Responses\GetSubscriptionPlansResponse;
use PaylandsSDK\Responses\GetSubscriptionProductsResponse;
use PaylandsSDK\Responses\GetSubscriptionsResponse;
use PaylandsSDK\Responses\RefundResponse;
use PaylandsSDK\Responses\RemoveCardResponse;
use PaylandsSDK\Responses\RemoveCustomerAccountResponse;
use PaylandsSDK\Responses\RemoveCustomerAddressResponse;
use PaylandsSDK\Responses\RemoveSubscriptionPlanResponse;
use PaylandsSDK\Responses\RemoveSubscriptionProductResponse;
use PaylandsSDK\Responses\RemoveSubscriptionResponse;
use PaylandsSDK\Responses\SaveCardResponse;
use PaylandsSDK\Responses\SaveCardsResponse;
use PaylandsSDK\Responses\SendOneStepPaymentResponse;
use PaylandsSDK\Responses\SendPaymentFileResponse;
use PaylandsSDK\Responses\SendPayoutResponse;
use PaylandsSDK\Responses\SendRefundsFileResponse;
use PaylandsSDK\Responses\SendWSPaymentResponse;
use PaylandsSDK\Responses\SetCardDescriptionResponse;
use PaylandsSDK\Responses\SubscribeCustomerResponse;
use PaylandsSDK\Responses\UpdateCustomerAccountResponse;
use PaylandsSDK\Responses\UpdateCustomerAddressResponse;
use PaylandsSDK\Responses\UpdateCustomerProfileResponse;
use PaylandsSDK\Responses\ValidateTokenizedCardResponse;
use PaylandsSDK\Types\Account;
use PaylandsSDK\Types\Antifraud;
use PaylandsSDK\Types\BatchError;
use PaylandsSDK\Types\Branch;
use PaylandsSDK\Types\CampaignDetail;
use PaylandsSDK\Types\Card;
use PaylandsSDK\Types\Client;
use PaylandsSDK\Types\Customer;
use PaylandsSDK\Types\CustomerAddress;
use PaylandsSDK\Types\CustomerCard;
use PaylandsSDK\Types\CustomerProfile;
use PaylandsSDK\Types\Enums\AccountType;
use PaylandsSDK\Types\Enums\AddressType;
use PaylandsSDK\Types\Enums\CardType;
use PaylandsSDK\Types\Enums\DocumentIdentificationIssuer;
use PaylandsSDK\Types\Enums\DocumentIdentificationType;
use PaylandsSDK\Types\Enums\EntryType;
use PaylandsSDK\Types\Enums\Evaluation;
use PaylandsSDK\Types\Enums\MoToCampaignStatus;
use PaylandsSDK\Types\Enums\MoToCampaignType;
use PaylandsSDK\Types\Enums\Operative;
use PaylandsSDK\Types\Enums\OrderStatus;
use PaylandsSDK\Types\Enums\PaymentTypeCd;
use PaylandsSDK\Types\Enums\SubscriptionInterval;
use PaylandsSDK\Types\Enums\SubscriptionPaymentStatus;
use PaylandsSDK\Types\Enums\SubscriptionStatus;
use PaylandsSDK\Types\Enums\TransactionStatus;
use PaylandsSDK\Types\ErrorResponse;
use PaylandsSDK\Types\MotoCampaignPayment;
use PaylandsSDK\Types\Order;
use PaylandsSDK\Types\PaymentAgent;
use PaylandsSDK\Types\PaymentType;
use PaylandsSDK\Types\Phone;
use PaylandsSDK\Types\Product;
use PaylandsSDK\Types\State;
use PaylandsSDK\Types\Subscription;
use PaylandsSDK\Types\SubscriptionCompany;
use PaylandsSDK\Types\SubscriptionPayment;
use PaylandsSDK\Types\SubscriptionPlan;
use PaylandsSDK\Types\SubscriptionProduct;
use PaylandsSDK\Types\Transaction;
use PaylandsSDK\Types\TransactionOrder;
use PaylandsSDK\Utils\HttpClient;

/**
 * Class PaylandsClient
 * @package PaylandsSDK
 */
class PaylandsClient
{
    /**
     * @var ClientSettings
     */
    private $clientSettings;

    /**
     * @var HttpClient
     */
    private $http;

    public function __construct(ClientSettings $clientSettings, HttpClient $http)
    {
        $this->clientSettings = $clientSettings;
        $this->http = $http;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return array
     */
    private function handleRequest(string $method, string $uri, array $options = []): array
    {
        if (in_array(strtolower($method), ['post', 'put', 'delete'])) {
            $options = array_merge_recursive([
                "json" => [
                    "signature" => $this->clientSettings->getSignature()
                ],
            ], $options);
        }
        $response = $this->http->request($method, $uri, $options);

        $body = json_decode($response->getContent(), true);

        if ($response->isSuccessful()) {
            return $body;
        }

        throw new PaylandsClientException(new ErrorResponse(
            $body['message'],
            $body['code'],
            isset($body['details']) ? $body['details'] : null
        ));
    }

    /********* API KEYS *********/
    /**
     * @return GetApiKeyProfilesResponse
     */
    public function getApiKeyProfiles()
    {
        $body = $this->handleRequest('GET', 'api-key/profiles');

        return new GetApiKeyProfilesResponse(
            $body['message'],
            $body['code'],
            $body['current_time'],
            $body['profiles']
        );
    }

    /**
     * @return GetMyApiKeyProfilesResponse
     */
    public function getMyApiKeyProfiles()
    {
        $body = $this->handleRequest('GET', 'api-key/me');

        return new GetMyApiKeyProfilesResponse(
            $body['message'],
            $body['code'],
            $body['current_time'],
            $body['profiles'],
            $body['is_pci']
        );
    }

    /********* FIN API KEYS *********/

    /********* PERFIL CLIENTE *********/
    /**
     * @param CreateCustomerRequest $request
     * @return CreateCustomerResponse
     */
    public function createCustomer(CreateCustomerRequest $request)
    {
        $response = $this->handleRequest('POST', 'customer', ["json" => $request->parseRequest()]);
        return new CreateCustomerResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['Customer']['external_id'], $response['Customer']['token'])
        );
    }

    /**
     * @param CreateCustomerProfileRequest $request
     * @return CreateCustomerProfileResponse
     */
    public function createCustomerProfile(CreateCustomerProfileRequest $request)
    {
        $response = $this->handleRequest('POST', 'customer/profile', ["json" => $request->parseRequest()]);
        return new CreateCustomerProfileResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['customer']['external_id']),
            $this->generateCustomerProfileFromResponse($response['customer_profile'])
        );
    }

    /**
     * @param UpdateCustomerProfileRequest $request
     * @return UpdateCustomerProfileResponse
     */
    public function updateCustomerProfile(UpdateCustomerProfileRequest $request)
    {
        $response = $this->handleRequest('PUT', 'customer/profile', ["json" => $request->parseRequest()]);
        return new UpdateCustomerProfileResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['customer']['external_id']),
            $this->generateCustomerProfileFromResponse($response['customer_profile'])
        );
    }

    /**
     * @param GetCustomerProfileRequest $request
     * @return GetCustomerProfileResponse
     */
    public function getCustomerProfile(GetCustomerProfileRequest $request)
    {
        $response = $this->handleRequest('GET', 'customer/profile/' . $request->getExternalId());
        return new GetCustomerProfileResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateCustomerProfileFromResponse($response['customer_profile'])
        );
    }
    /********* FIN  PERFIL CLIENTE *********/


    /********* CUENTA CLIENTE *********/
    /**
     * @param CreateCustomerAccountRequest $request
     * @return CreateCustomerAccountResponse
     */
    public function createCustomerAccount(CreateCustomerAccountRequest $request)
    {
        $response = $this->handleRequest('POST', 'customer/account', ["json" => $request->parseRequest()]);
        return new CreateCustomerAccountResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['customer']['external_id']),
            new Account(
                $response['customer_account']['uuid'],
                new AccountType($response['customer_account']['account_type']),
                $response['customer_account']['account_number']
            )
        );
    }

    /**
     * @param UpdateCustomerAccountRequest $request
     * @return UpdateCustomerAccountResponse
     */
    public function updateCustomerAccount(UpdateCustomerAccountRequest $request)
    {
        $response = $this->handleRequest('PUT', 'customer/account', ["json" => $request->parseRequest()]);
        return new UpdateCustomerAccountResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['customer']['external_id']),
            new Account(
                $response['customer_account']['uuid'],
                new AccountType($response['customer_account']['account_type']),
                $response['customer_account']['account_number']
            )
        );
    }

    /**
     * @param GetCustomerAccountRequest $request
     * @return GetCustomerAccountResponse
     */
    public function getCustomerAccount(GetCustomerAccountRequest $request)
    {
        $response = $this->handleRequest('GET', 'customer/account/' . $request->getUuid());
        return new GetCustomerAccountResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Account(
                $response['customer_account']['uuid'],
                new AccountType($response['customer_account']['account_type']),
                $response['customer_account']['account_number']
            )
        );
    }

    /**
     * @param RemoveCustomerAccountRequest $request
     * @return RemoveCustomerAccountResponse
     */
    public function removeCustomerAccount(RemoveCustomerAccountRequest $request)
    {
        $response = $this->handleRequest('DELETE', 'customer/account', ["json" => $request->parseRequest()]);
        return new RemoveCustomerAccountResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Account(
                $response['customer_account']['uuid'],
                new AccountType($response['customer_account']['account_type']),
                $response['customer_account']['account_number']
            )
        );
    }

    /********* FIN  CUENTA CLIENTE *********/

    /********* DIRECCIÓN CLIENTE *********/
    /**
     * @param CreateCustomerAddressRequest $request
     * @return CreateCustomerAddressResponse
     */
    public function createCustomerAddress(CreateCustomerAddressRequest $request)
    {
        $response = $this->handleRequest('POST', 'customer/address', ["json" => $request->parseRequest()]);
        return new CreateCustomerAddressResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['customer']['external_id']),
            $this->generateCustomerAddressFromResponse($response['customer_address'])
        );
    }

    /**
     * @param UpdateCustomerAddressRequest $request
     * @return UpdateCustomerAddressResponse
     */
    public function updateCustomerAddress(UpdateCustomerAddressRequest $request)
    {
        $response = $this->handleRequest('PUT', 'customer/address', ["json" => $request->parseRequest()]);
        return new UpdateCustomerAddressResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['customer']['external_id']),
            $this->generateCustomerAddressFromResponse($response['customer_address'])
        );
    }

    /**
     * @param GetCustomerAddressRequest $request
     * @return GetCustomerAddressResponse
     */
    public function getCustomerAddress(GetCustomerAddressRequest $request)
    {
        $response = $this->handleRequest('GET', 'customer/address/' . $request->getUuid());
        return new GetCustomerAddressResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateCustomerAddressFromResponse($response['customer_address'])
        );
    }

    /**
     * @param RemoveCustomerAddressRequest $request
     * @return RemoveCustomerAddressResponse
     */
    public function removeCustomerAddress(RemoveCustomerAddressRequest $request)
    {
        $response = $this->handleRequest('DELETE', 'customer/address', ["json" => $request->parseRequest()]);
        return new RemoveCustomerAddressResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateCustomerAddressFromResponse($response['customer_address'])
        );
    }

    /********* FIN  DIRECCIÓN CLIENTE *********/


    /********* TARJETAS *********/
    /**
     * @param SetCardDescriptionRequest $request
     * @return SetCardDescriptionResponse
     */
    public function setCardDescription(SetCardDescriptionRequest $request)
    {
        $response = $this->handleRequest('PUT', 'payment-method/card/additional', ["json" => $request->parseRequest()]);

        return new SetCardDescriptionResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['Customer']['external_id'], null),
            $this->generateCardFromResponse($response['Source'])
        );
    }

    /**
     * @param RemoveCardRequest $request
     * @return RemoveCardResponse
     */
    public function removeCard(RemoveCardRequest $request)
    {
        $response = $this->handleRequest('DELETE', 'payment-method/card', ["json" => $request->parseRequest()]);
        return new RemoveCardResponse(
            $response['message'],
            $response['code'],
            $response['current_time']
        );
    }

    /**
     * @param SaveCardRequest $request
     * @return SaveCardResponse
     */
    public function saveCard(SaveCardRequest $request)
    {
        $response = $this->handleRequest('POST', 'payment-method/card', ["json" => $request->parseRequest()]);
        return new SaveCardResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['Customer']['external_id']),
            $this->generateCardFromResponse($response['Source'])
        );
    }

    /**
     * @param SaveCardsRequest $request
     * @return SaveCardsResponse
     */
    public function saveCards(SaveCardsRequest $request)
    {
        $response = $this->handleRequest('POST', 'payment-method/card/batch', ["json" => $request->parseRequest()]);
        return new SaveCardsResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            array_map(function ($cc) {
                return new CustomerCard(
                    new Customer($cc["Customer"]["external_id"]),
                    $this->generateCardFromResponse($cc["Source"])
                );
            }, $response["cards"])
        );
    }

    /**
     * @param GetCardRequest $request
     * @return GetCardResponse
     */
    public function getCard(GetCardRequest $request)
    {
        $response = $this->handleRequest('GET', 'payment-method/card/' . $request->getCardUuid());
        return new GetCardResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['Customer']['external_id']),
            $this->generateCardFromResponse($response['Source'])
        );
    }

    /**
     * @param GetCustomerCardsRequest $request
     * @return GetCustomerCardsResponse
     */
    public function getCustomerCards(GetCustomerCardsRequest $request)
    {
        $response = $this->handleRequest(
            'GET',
            "customer/" . $request->getCustomerExtId() . "/cards",
            [
                "query" => [
                    "status" => is_null($request->getStatus()) ? null : $request->getStatus()->getValue(),
                    "unique" => $request->isUnique() ?? null
                ]
            ]
        );
        return new GetCustomerCardsResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            array_map(function ($card) {
                return $this->generateCardFromResponse($card);
            }, $response['cards'])
        );
    }

    /**
     * @param ValidateTokenizedCardRequest $request
     * @return ValidateTokenizedCardResponse
     */
    public function validateTokenizedCard(ValidateTokenizedCardRequest $request)
    {
        $response = $this->handleRequest(
            'GET',
            'payment-method/card/validate',
            ['json' => $request->parseRequest()]
        );
        return new ValidateTokenizedCardResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Customer($response['Customer']['external_id']),
            $this->generateCardFromResponse($response['Source'])
        );
    }

    /********* FIN TARJETAS *********/


    /********* BTS *********/

    /** @param GetPaymentAgentsRequest $request
     * @return GetPaymentAgentsResponse
     */
    public function getPaymentAgents(GetPaymentAgentsRequest $request)
    {
        $response = $this->handleRequest(
            'POST',
            'bts/payment-agents',
            ['json' => $request->parseRequest()]
        );
        return new GetPaymentAgentsResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            array_map(function ($a) {
                return new PaymentAgent($a["code"], $a["description"]);
            }, $response["paymentAgents"])
        );
    }

    /**
     * @param GetPaymentTypeByAgentRequest $request
     * @return GetPaymentTypeByAgentResponse
     */
    public function getPaymentTypeByAgent(GetPaymentTypeByAgentRequest $request)
    {
        $response = $this->handleRequest(
            'POST',
            'bts/payment-agents-payment-types',
            ['json' => $request->parseRequest()]
        );
        return new GetPaymentTypeByAgentResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            array_map(function ($a) {
                return new PaymentType(
                    $a['pay_agent_cd'],
                    new PaymentTypeCd($a['payment_type_cd']),
                    $a['dest_country_cd'],
                    $a['dest_currency_cd']
                );
            }, $response["payment_types"])
        );
    }

    /**
     * @param GetAccountTypeByAgentRequest $request
     * @return GetAccountTypeByAgentResponse
     */
    public function getAccountTypeByAgent(GetAccountTypeByAgentRequest $request)
    {
        $response = $this->handleRequest(
            'POST',
            'bts/account-types-payment-agents',
            ['json' => $request->parseRequest()]
        );
        return new GetAccountTypeByAgentResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $response["accounts"]
        );
    }

    /**
     * @param GetStatesRequest $request
     * @return GetStatesResponse
     */
    public function getStates(GetStatesRequest $request)
    {
        $response = $this->handleRequest(
            'POST',
            'bts/states',
            ['json' => $request->parseRequest()]
        );
        return new GetStatesResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            array_map(function ($s) {
                return new State(
                    $s['state_sd'],
                    $s['state_cd'],
                    $s['country_cd']
                );
            }, $response['states'])
        );
    }

    /**
     * @param GetBranchesRequest $request
     * @return GetBranchesResponse
     */
    public function getBranches(GetBranchesRequest $request)
    {
        $response = $this->handleRequest(
            'POST',
            'bts/branches',
            ['json' => $request->parseRequest()]
        );
        return new GetBranchesResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            array_map(function ($b) {
                return new Branch(
                    $b['pay_agent_cd'],
                    $b['pay_agent_region_sd'],
                    $b['pay_agent_branch_sd'],
                    $b['pay_agent_branch_ds'],
                    $b['pay_agent_country_cd'],
                    $b['pay_agent_state_sd'],
                    $b['pay_agent_city'],
                    $b['pay_agent_address'],
                    $b['pay_agent_zipcode'],
                    $b['pay_agent_phone'],
                    $b['pay_agent_schedule']
                );
            }, $response['branches'])
        );
    }

    /**
     * @param GetProductsRequest $request
     * @return GetProductsResponse
     */
    public function getProducts(GetProductsRequest $request)
    {
        $response = $this->handleRequest(
            'POST',
            'bts/products',
            ['json' => $request->parseRequest()]
        );
        return new GetProductsResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            array_map(function ($p) {
                return new Product(
                    $p['serviceCode'],
                    $p['originCountryCode'],
                    $p['originCurrencyCode'],
                    $p['destinationCountryCode'],
                    $p['destinationCurrencyCode'],
                    new PaymentTypeCd($p['paymentTypeCode']),
                    $p['directedTransactionCode'],
                    $p['electronicFundsCode']
                );
            }, $response['products'])
        );
        ;
    }

    /********* FIN BTS *********/

    /********* MO TO  ********/

    /**
     * @param CreateMotoCampaignRequest $request
     * @return CreateMotoCampaignResponse
     */

    public function createMotoCampaign(CreateMotoCampaignRequest $request)
    {
        $response = $this->handleRequest('POST', 'payment/moto/csv', ["json" => $request->parseRequest()]);
        $detail = new CampaignDetail(
            $response['detail']['uuid'],
            $response['detail']['description'],
            $response['detail']['serviceUUID'],
            $response['detail']['clientID'],
            $response['detail']['clientUUID'],
            new MoToCampaignType($response['detail']['type']),
            new EntryType($response['detail']['entry']),
            $response['detail']['expiresAt'],
            $response['detail']['subject'],
            $response['detail']['filename'],
            $response['detail']['id'],
            new MoToCampaignStatus($response['detail']['status']),
            $response['detail']['createdAt'],
            $response['detail']['error'] ?? null
        );
        $payments = array_map(function ($payment) {
            return new MotoCampaignPayment(
                $payment['id'],
                $payment['uuid'],
                $payment['detailUUID'],
                $payment['line'],
                new MoToCampaignStatus($payment['status']),
                $payment['amount'],
                new Operative($payment['operative']),
                $payment['secure'],
                $payment['destination'],
                $payment['createdAt'],
                $payment['urlPost'],
                $payment['urlOk'],
                $payment['urlKo'],
                $payment['externalID'],
                $payment['additional'],
                $payment['cardTemplate'],
                $payment['dccTemplate'],
                $payment['moToTemplate']
            );
        }, $response['payments']);

        return new CreateMotoCampaignResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $detail,
            $payments
        );
    }

    /********* FIN MO TO  *********/


    /********* PAGOS  **********/

    /**
     * @param GeneratePaymentOrderRequest $request
     * @return GeneratePaymentOrderResponse
     */


    public function generatePaymentOrder(GeneratePaymentOrderRequest $request)
    {
        $response = $this->handleRequest('POST', 'payment', ["json" => $request->parseRequest()]);
        return new GeneratePaymentOrderResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateOrderFromResponse($response['order']),
            new Client(
                $response['client']['uuid']
            ),
            is_null($response['extra_data']) ? null : new PaymentOrderExtraData(
                new Payment($response['extra_data']['payment']['installments'])
            )
        );
    }

    /**
     * @param GetRedirectPaymentURLRequest $request
     * @return string
     */
    public function getRedirectPaymentURL(GetRedirectPaymentURLRequest $request)
    {
        return $this->http->getBaseUri() . "payment/process/" . $request->getToken();
    }

    /**
     * @param SendWSPaymentRequest $request
     * @return SendWSPaymentResponse
     */
    public function sendWSPayment(SendWSPaymentRequest $request)
    {
        $response = $this->handleRequest('POST', 'payment/direct', ["json" => $request->parseRequest()]);
        return new SendWSPaymentResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateOrderFromResponse($response['order']),
            new Client(
                $response['client']['uuid']
            ),
            is_null($response['extra_data']) ? null : new PaymentOrderExtraData(
                new Payment($response['extra_data']['payment']['installments'])
            )
        );
    }

    /**
     * @param SendTokenizedPaymentRequest $request
     * @return mixed
     */
    public function getTokenizedPaymentURL(SendTokenizedPaymentRequest $request)
    {
        return $this->http->getBaseUri() . "payment/tokenized/" . $request->getToken();
    }

    /**
     * @param RefundRequest $request
     * @return RefundResponse
     */
    public function refund(RefundRequest $request)
    {
        $response = $this->handleRequest('POST', 'payment/refund', ["json" => $request->parseRequest()]);
        return new RefundResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateOrderFromResponse($response['order']),
            new Client(
                $response['client']['uuid']
            ),
            is_null($response['extra_data']) ? null : new PaymentOrderExtraData(
                new Payment($response['extra_data']['payment']['installments'])
            )
        );
    }

    /**
     * @param ConfirmPaymentRequest $request
     * @return ConfirmPaymentResponse
     */
    public function confirmPayment(ConfirmPaymentRequest $request)
    {
        $response = $this->handleRequest('POST', 'payment/confirmation', ["json" => $request->parseRequest()]);
        return new ConfirmPaymentResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateOrderFromResponse($response['order']),
            new Client(
                $response['client']['uuid']
            ),
            is_null($response['extra_data']) ? null : new PaymentOrderExtraData(
                new Payment($response['extra_data']['payment']['installments'])
            )
        );
    }

    /**
     * @param CancelPaymentRequest $request
     * @return CancelPaymentResponse
     */
    public function cancelPayment(CancelPaymentRequest $request)
    {
        $response = $this->handleRequest('POST', 'payment/cancellation', ["json" => $request->parseRequest()]);
        return new CancelPaymentResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateOrderFromResponse($response['order']),
            new Client(
                $response['client']['uuid']
            ),
            is_null($response['extra_data']) ? null : new PaymentOrderExtraData(
                new Payment($response['extra_data']['payment']['installments'])
            )
        );
    }

    /**
     * @param SendPayoutRequest $request
     * @return SendPayoutResponse
     */
    public function sendPayout(SendPayoutRequest $request)
    {
        $response = $this->handleRequest('POST', 'payment/payout', ["json" => $request->parseRequest()]);

        return new SendPayoutResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateOrderFromResponse($response['order']),
            new Client($response['client']['uuid']),
            is_null($response['extra_data']) ? null : new PaymentOrderExtraData(
                new Payment($response['extra_data']['payment']['installments'])
            )
        );
    }

    /**
     * @param SendOneStepPaymentRequest $request
     * @return SendOneStepPaymentResponse
     */
    public function sendOneStepPayment(SendOneStepPaymentRequest $request)
    {
        $response = $this->handleRequest('POST', 'charge', ["json" => $request->parseRequest()]);
        return new SendOneStepPaymentResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateOrderFromResponse($response['order']),
            new Client(
                $response['client']['uuid']
            ),
            is_null($response['extra_data']) ? null : new PaymentOrderExtraData(
                new Payment($response['extra_data']['payment']['installments'])
            )
        );
    }

    /********* FIN PAGOS  *********/


    /********* BATCH  ********/
    /**
     * @param SendPaymentFileRequest $request
     * @return SendPaymentFileResponse
     */


    public function sendPaymentFile(SendPaymentFileRequest $request)
    {
        $response = $this->handleRequest('POST', 'batch/authorizations', ["json" => $request->parseRequest()]);
        return new SendPaymentFileResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            array_map(function ($err) {
                return new BatchError($err["line"], $err["msg"]);
            }, $response['errors'])
        );
    }

    /**
     * @param SendRefundsFileRequest $request
     * @return SendRefundsFileResponse
     */
    public function sendRefundsFile(SendRefundsFileRequest $request)
    {
        $response = $this->handleRequest('POST', 'batch/refunds', ["json" => $request->parseRequest()]);
        return new SendRefundsFileResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            array_map(function ($err) {
                return new BatchError($err["line"], $err["msg"]);
            }, $response['errors'])
        );
    }
    /********* FIN BATCH  *********/

    /********* ORDERS  ******** */
    /**
     * @param GetOrderRequest $request
     * @return mixed
     */

    public function getOrder(GetOrderRequest $request)
    {
        $response = $this->handleRequest('GET', 'order/' . $request->getOrderUuid());
        return new GetOrderResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $this->generateOrderFromResponse($response['order']),
            new Client($response['client']['uuid']),
            is_null($response['extra_data']) ? null : new PaymentOrderExtraData(
                new Payment($response['extra_data']['payment']['installments'])
            )
        );
    }

    /**
     * @param GetOrdersRequest $request
     * @return GetOrdersResponse
     */
    public function getOrders(GetOrdersRequest $request)
    {
        $response = $this->handleRequest('GET', 'orders', ["query" => $request->parseRequest()]);
        return new GetOrdersResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $response['count'],
            array_map(function ($t) {
                return new TransactionOrder(
                    $t['transactionUUID'],
                    $t['orderUUID'],
                    $t['clientUUID'],
                    $t['customerExtId'],
                    $t['sourceType'],
                    $t['holder'],
                    $t['country'],
                    $t['token'],
                    $t['pan'],
                    $t['bank'],
                    $t['created'],
                    $t['amount'],
                    $t['processorID'],
                    new TransactionStatus($t['status']),
                    $t['error'],
                    $t['authorization'],
                    $t['serviceUUID'],
                    $t['type'],
                    $t['ip'],
                    $t['additional'],
                    $t['terminal'],
                    $t['sourceAdditional'] ?? null,
                    $t['sourcePrepaid'],
                    $t['currency']
                );
            }, $response['transactions'])
        );
    }
    /********* FIN ORDERS  *********/


    /********* SUBSCRIPCIONES  *********/

    /**
     * @return CreateSubscriptionCompanyResponse
     */
    public function createSubscriptionCompany()
    {
        $response = $this->handleRequest("POST", "subscriptions/company");
        $company = new SubscriptionCompany(
            $response["company"]["name"],
            $response["company"]["external_id"],
            $response["company"]["created_at"],
            $response["company"]["updated_at"]
        );
        return new CreateSubscriptionCompanyResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $company
        );
    }

    /**
     * @param CreateSubscriptionProductRequest $request
     * @return CreateSubscriptionProductResponse
     */
    public function createSubscriptionProduct(CreateSubscriptionProductRequest $request)
    {
        $response = $this->handleRequest("POST", "subscriptions/product", ["json" => $request->parseRequest()]);
        $product = new SubscriptionProduct(
            $response['product']['name'],
            $response['product']['external_id'],
            $response['product']['sandbox'],
            $response['product']['notification_url'],
            $response['product']['created_at'],
            $response['product']['updated_at']
        );
        return new CreateSubscriptionProductResponse(
            $response["message"],
            $response["code"],
            $response["current_time"],
            $product
        );
    }

    /**
     * @return GetSubscriptionProductsResponse
     */
    public function getSubscriptionProducts()
    {
        $response = $this->handleRequest("GET", "subscriptions/products");
        $products = array_map(function ($product) {
            return new SubscriptionProduct(
                $product['name'],
                $product['external_id'],
                $product['sandbox'],
                $product['notification_url'],
                $product['created_at'],
                $product['updated_at']
            );
        }, $response['products']);

        return new GetSubscriptionProductsResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $products
        );
    }

    /**
     * @param RemoveSubscriptionProductRequest $request
     * @return RemoveSubscriptionProductResponse
     */
    public function removeSubscriptionProduct(RemoveSubscriptionProductRequest $request)
    {
        $response = $this->handleRequest("DELETE", "subscriptions/product/" . $request->getProductExternalId());

        return new RemoveSubscriptionProductResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $response['deleted']
        );
    }

    /**
     * @param CreateSubscriptionPlanRequest $request
     * @return CreateSubscriptionPlanResponse
     */
    public function createSubscriptionPlan(CreateSubscriptionPlanRequest $request)
    {
        $response = $this->handleRequest("POST", "subscriptions/plan", ["json" => $request->parseRequest()]);

        $plan = new SubscriptionPlan(
            $response['plan']['name'],
            $response['plan']['external_id'],
            $response['plan']['amount'],
            $response['plan']['interval'],
            new SubscriptionInterval($response['plan']['interval_type']),
            $response['plan']['trial_available'],
            $response['plan']['created_at'],
            $response['plan']['updated_at'],
            new SubscriptionProduct(
                $response['plan']['product']['name'],
                $response['plan']['product']['external_id'],
                $response['plan']['product']['sandbox'],
                $response['plan']['product']['notification_url'],
                $response['plan']['product']['created_at'],
                $response['plan']['product']['updated_at']
            ),
            $response['plan']['interval_offset'],
            new SubscriptionInterval($response['plan']['interval_offset_type'])
        );
        return new CreateSubscriptionPlanResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $plan
        );
    }

    /**
     * @return GetSubscriptionPlansResponse
     */
    public function getSubscriptionPlans()
    {
        $response = $this->handleRequest("GET", "subscriptions/plans");

        $plans = array_map(function ($plan) {
            return new SubscriptionPlan(
                $plan['name'],
                $plan['external_id'],
                $plan['amount'],
                $plan['interval'],
                new SubscriptionInterval($plan['interval_type']),
                $plan['trial_available'],
                $plan['created_at'],
                $plan['updated_at'],
                new SubscriptionProduct(
                    $plan['product']['name'],
                    $plan['product']['external_id'],
                    $plan['product']['sandbox'],
                    $plan['product']['notification_url'],
                    $plan['product']['created_at'],
                    $plan['product']['updated_at']
                ),
                $plan['interval_offset'],
                new SubscriptionInterval($plan['interval_offset_type'])
            );
        }, $response['plans']);

        return new GetSubscriptionPlansResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $plans
        );
    }

    /**
     * @param RemoveSubscriptionPlanRequest $request
     * @return RemoveSubscriptionPlanResponse
     */
    public function removeSubscriptionPlan(RemoveSubscriptionPlanRequest $request)
    {
        $response = $this->handleRequest("DELETE", "subscriptions/plan/" . $request->getPlanExternalId());

        return new RemoveSubscriptionPlanResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $response['deleted']
        );
    }

    /**
     * @param SubscribeCustomerRequest $request
     * @return SubscribeCustomerResponse
     */
    public function subscribeCustomer(SubscribeCustomerRequest $request)
    {
        $response = $this->handleRequest("POST", "subscriptions/subscription", ["json" => $request->parseRequest()]);
        return new SubscribeCustomerResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            new Subscription(
                $response['subscription']['id'],
                $response['subscription']['active'],
                new SubscriptionStatus($response['subscription']['status']),
                $response['subscription']['total_payment_number'],
                $response['subscription']['total_payment_charged'],
                $response['subscription']['payment_attempts_limit'],
                $response['subscription']['first_charge_date'],
                $response['subscription']['next_charge_date'],
                $response['subscription']['additional_data'],
                $response['subscription']['created_at'],
                $response['subscription']['updated_at'],
                new SubscriptionPlan(
                    $response['subscription']['plan']['name'],
                    $response['subscription']['plan']['external_id'],
                    $response['subscription']['plan']['amount'],
                    $response['subscription']['plan']['interval'],
                    new SubscriptionInterval($response['subscription']['plan']['interval_type']),
                    $response['subscription']['plan']['trial_available'],
                    $response['subscription']['plan']['created_at'],
                    $response['subscription']['plan']['updated_at'],
                    new SubscriptionProduct(
                        $response['subscription']['plan']['product']['name'],
                        $response['subscription']['plan']['product']['external_id'],
                        $response['subscription']['plan']['product']['sandbox'],
                        $response['subscription']['plan']['product']['notification_url'],
                        $response['subscription']['plan']['product']['created_at'],
                        $response['subscription']['plan']['product']['updated_at']
                    ),
                    $response['subscription']['plan']['interval_offset'],
                    $response['subscription']['plan']['interval_offset_type'] ? new SubscriptionInterval($response['subscription']['plan']['interval_offset_type']) : null
                ),
                array_map(function ($payment) {
                    return new SubscriptionPayment(
                        $payment['id'],
                        new SubscriptionPaymentStatus($payment['status']),
                        $payment['payment_date'],
                        $payment['payment_number'],
                        $payment['attempt'],
                        $payment['amount'],
                        $payment['created_at'],
                        $payment['updated_at'],
                        $payment['payment_details']
                    );
                }, $response['subscription']['payments'])
            )
        );
    }

    /**
     * @return GetSubscriptionsResponse
     */
    public function getSubscriptions()
    {
        $response = $this->handleRequest("GET", "subscriptions/subscriptions");

        $subscriptions = array_map(function ($subscription) {
            return new Subscription(
                $subscription['id'],
                $subscription['active'],
                new SubscriptionStatus($subscription['status']),
                $subscription['total_payment_number'],
                $subscription['total_payment_charged'],
                $subscription['payment_attempts_limit'],
                $subscription['first_charge_date'],
                $subscription['next_charge_date'],
                $subscription['additional_data'],
                $subscription['created_at'],
                $subscription['updated_at'],
                new SubscriptionPlan(
                    $subscription['plan']['name'],
                    $subscription['plan']['external_id'],
                    $subscription['plan']['amount'],
                    $subscription['plan']['interval'],
                    new SubscriptionInterval($subscription['plan']['interval_type']),
                    $subscription['plan']['trial_available'],
                    $subscription['plan']['created_at'],
                    $subscription['plan']['updated_at'],
                    new SubscriptionProduct(
                        $subscription['plan']['product']['name'],
                        $subscription['plan']['product']['external_id'],
                        $subscription['plan']['product']['sandbox'],
                        $subscription['plan']['product']['notification_url'],
                        $subscription['plan']['product']['created_at'],
                        $subscription['plan']['product']['updated_at']
                    ),
                    $subscription['plan']['interval_offset'],
                    $subscription['plan']['interval_offset_type'] ? new SubscriptionInterval($subscription['plan']['interval_offset_type']) : null
                ),
                array_map(function ($payment) {
                    return new SubscriptionPayment(
                        $payment['id'],
                        new SubscriptionPaymentStatus($payment['status']),
                        $payment['payment_date'],
                        $payment['payment_number'],
                        $payment['attempt'],
                        $payment['amount'],
                        $payment['created_at'],
                        $payment['updated_at'],
                        $payment['payment_details']
                    );
                }, $subscription['payments'])
            );
        }, $response['subscriptions']);

        return new GetSubscriptionsResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $subscriptions
        );
    }

    /**
     * @param RemoveSubscriptionRequest $request
     * @return RemoveSubscriptionResponse
     */
    public function removeSubscription(RemoveSubscriptionRequest $request)
    {
        $response = $this->handleRequest("DELETE", "subscriptions/subscription/" . $request->getSubscriptionId());

        return new RemoveSubscriptionResponse(
            $response['message'],
            $response['code'],
            $response['current_time'],
            $response['deleted']
        );
    }
    /********* FIN SUBSCRIPCIONES  *********/

    /**
     * @param array $response
     * @return Order
     */
    private function generateOrderFromResponse(array $response): Order
    {
        return new Order(
            $response['uuid'],
            $response['created'],
            $response['created_from_client_timezone'],
            $response['amount'],
            $response['currency'],
            $response['paid'],
            $response['safe'],
            $response['refunded'],
            $response['service'],
            new OrderStatus($response['status']),
            array_map(function ($t) {
                return new Transaction(
                    $t['uuid'],
                    $t['created'],
                    $t['created_from_client_timezone'],
                    new Operative($t['operative']),
                    $t['amount'],
                    $t['authorization'],
                    $t['error'],
                    $this->generateCardFromResponse($t['source']),
                    new TransactionStatus($t['status']),
                    (!isset($t['antifraud']) || is_null($t['antifraud'])) ? null : new Antifraud(
                        new Evaluation($t['antifraud']['evaluation']),
                        $t['antifraud']['score'],
                        $t['antifraud']['risk_score'],
                        $t['antifraud']['fraud_score']
                    )
                );
            }, $response['transactions']),
            $response['token'],
            $response['ip'] ?? null,
            $response['customer'] ?? null,
            $response['additional'] ?? null
        );
    }

    /**
     * @param array $response
     * @return Card
     */
    private function generateCardFromResponse(array $response): Card
    {
        return new Card(
            $response['object'],
            $response['uuid'],
            new CardType($response['type']),
            $response['token'],
            $response['brand'],
            $response['country'],
            $response['holder'],
            $response['bin'],
            $response['last4'],
            $response['expire_month'],
            $response['expire_year'],
            $response['bank'],
            $response['prepaid'] ?? null,
            $response['validation_date'] ?? null,
            $response['additional'] ?? null
        );
    }

    /**
     * @param array $response
     * @return CustomerProfile
     */
    private function generateCustomerProfileFromResponse(array $response): CustomerProfile
    {
        return new CustomerProfile(
            $response['first_name'],
            $response['last_name'],
            $response['cardholder_name'],
            new DocumentIdentificationIssuer($response['document_identification_issuer_type']),
            new DocumentIdentificationType($response['document_identification_type']),
            $response['document_identification_number'],
            $response['birthdate'],
            $response['source_of_funds'],
            $response['occupation'],
            $response['social_security_number'],
            $response['created_at'],
            $response['updated_at'],
            $response['email'],
            new Phone($response['phone']['number'], $response['phone']['prefix']),
            new Phone($response['home_phone']['number'], $response['home_phone']['prefix']),
            new Phone($response['work_phone']['number'], $response['work_phone']['prefix']),
            new Phone($response['mobile_phone']['number'], $response['mobile_phone']['prefix'])
        );
    }

    /**
     * @param array $response
     * @return CustomerAddress
     */
    private function generateCustomerAddressFromResponse(array $response): CustomerAddress
    {
        return new CustomerAddress(
            $response['uuid'],
            $response['address1'],
            $response['address2'],
            $response['address3'],
            $response['city'],
            $response['state_code'],
            $response['country'],
            $response['zip_code'],
            isset($response['type']) && AddressType::isValid($response['type']) ? new AddressType($response['type']) : null,
            $response['default'] ?? false
        );
    }
}
