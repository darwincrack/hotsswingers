<?php


namespace PaylandsSDK;

use PaylandsSDK\Types\Enums\Environment;

/**
 * Class ClientSettings
 * @package PaylandsSDK
 */
class ClientSettings
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var Environment
     */
    private $env;

    public function __construct(string $apiKey, string $signature, Environment $env)
    {
        $this->apiKey = $apiKey;
        $this->signature = $signature;
        $this->env = $env;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return Environment
     */
    public function getEnv()
    {
        return $this->env;
    }
}
