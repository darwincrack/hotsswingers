<?php

namespace PaylandsSDK\Utils;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use PaylandsSDK\Exceptions\PaylandsHttpException;

class HttpClient
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(array $config)
    {
        $this->client = new Client($config);
    }

    public function request(string $method, string $uri, array $options = []): HttpResponse
    {
        try {
            $response = $this->client->request($method, $uri, $options);
        } catch (BadResponseException $e) {
            if (is_null($e->getResponse())) {
                throw new PaylandsHttpException('Unexpected HTTP error: ' . $e->getMessage());
            }
            $response = $e->getResponse();
        } catch (ConnectException $e) {
            throw new PaylandsHttpException('Endpoint could not be reached in time: ' . $uri);
        } catch (TooManyRedirectsException $e) {
            throw new PaylandsHttpException('Too many redirects on endpoint: ' . $uri);
        } catch (Exception $e) {
            throw new PaylandsHttpException('Unexpected HTTP error: ' . $e->getMessage());
        }

        return new HttpResponse(
            $response->getHeaders(),
            $response->getStatusCode(),
            $response->getBody()->getContents()
        );
    }

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->client->getConfig("base_uri");
    }
}
