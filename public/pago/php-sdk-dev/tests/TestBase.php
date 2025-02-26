<?php

namespace PaylandsSDK\Tests;

use InvalidArgumentException;
use PaylandsSDK\ClientSettings;
use PaylandsSDK\PaylandsClient;
use PaylandsSDK\Types\Enums\Environment;
use PaylandsSDK\Utils\HttpClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

abstract class TestBase extends TestCase
{
    /**
     * @var HttpClient&MockObject
     */
    protected $httpClient;

    /**
     * @var PaylandsClient
     */
    protected $paylandsClient;

    /**
     * @return void
     */
    final protected function setUp()
    {
        $config = new ClientSettings("", "", Environment::SANDBOX());
        $this->httpClient = $this->createMock(HttpClient::class);
        $this->paylandsClient = new PaylandsClient($config, $this->httpClient);
    }

    /**
     * @return string
     */
    protected function getExpectedResponse()
    {
        $filepath = sprintf('%s/Expected/%s.json', $this->getTestDirectoryPath(), $this->getTestMethodName());

        if (file_exists($filepath)) {
            return file_get_contents($filepath) ?: "";
        }

        throw new InvalidArgumentException("Fixture with filepath $filepath does not exist or cannot be read.");
    }

    private function getTestDirectoryPath(): string
    {
        try {
            $reflectionClass = new ReflectionClass($this);
            $filepath = $reflectionClass->getFileName();
            if (!$filepath) {
                throw new InvalidArgumentException('Class' . get_class($this) . ' could not be located by reflection.');
            }

            return dirname($filepath);
        } catch (ReflectionException $e) {
            return "";
        }
    }

    /**
     * @return string
     */
    private function getTestMethodName(): string
    {
        return $this->getName();
    }
}
