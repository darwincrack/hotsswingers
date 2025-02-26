<?php

declare(strict_types=1);

namespace PaylandsSDK;

use PaylandsSDK\Types\Enums\Environment;
use PaylandsSDK\Utils\HttpClient;

class PaylandsClientFactory
{
    public function create(string $apiKey, string $signature, Environment $environment): PaylandsClient
    {
        return new PaylandsClient(
            new ClientSettings(
                $apiKey ?? $this->getValueFromEnvironment('PAYLANDS_API_KEY'),
                $signature ?? $this->getValueFromEnvironment('PAYLANDS_API_SIGNATURE'),
                $environment ?? new Environment($this->getValueFromEnvironment('PAYLANDS_API_ENV'))
            ),
            new HttpClient([
                "base_uri" => $this->getBaseUrl($environment),
                "headers" => [
                    "Accept" => "application/json",
                    "Content-Type" => "application/json",
                    "Authorization" => "Basic " . base64_encode($apiKey)
                ]
            ])
        );
    }

    private function getBaseUrl(Environment $environment): string
    {
        switch ($environment) {
            case Environment::SANDBOX:
                return $this->getValueFromEnvironment('PAYLANDS_SANDBOX_URL');
            default:
                return $this->getValueFromEnvironment('PAYLANDS_PRODUCTION_URL');
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function getValueFromEnvironment(string $name): string
    {
        if ($value = getenv($name, true)) {
            return (string)$value;
        }

        if ($value = getenv($name, false)) {
            return (string)$value;
        }

        if ($value = $_ENV[$name] ?? null) {
            return (string)$value;
        }

        if ($value = $_SERVER[$name] ?? null) {
            return (string)$value;
        }

        throw new \InvalidArgumentException("Missing environment value with name $name.");
    }
}
