<?php

declare(strict_types=1);

namespace Nofrixion\Client;

use Nofrixion\Exception\BadRequestException;
use Nofrixion\Exception\ForbiddenException;
use Nofrixion\Exception\RequestException;
use Nofrixion\Exception\NofrixionException;
use Nofrixion\Http\ClientInterface;
use Nofrixion\Http\CurlClient;
use Nofrixion\Http\Response;

class AbstractClient
{
    /** @var string */
    private $apiKey;
    /** @var string */
    private $baseUrl;
    /** @var string */
    private $apiPath = '/api/v1/';
    /** @var ClientInterface */
    private $httpClient;

    public function __construct(string $baseUrl, string $apiKey, ClientInterface $client = null)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;

        // Use the $client parameter to use a custom cURL client, for example if you need to disable CURLOPT_SSL_VERIFYHOST and CURLOPT_SSL_VERIFYPEER
        if ($client === null) {
            $client = new CurlClient();
        }
        $this->httpClient = $client;
    }

    protected function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function getApiUrl(): string
    {
        return $this->baseUrl . $this->apiPath;
    }

    protected function getApiKey(): string
    {
        return $this->apiKey;
    }

    protected function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @param bool $sendJson Set true to set 'Content-Type = application/json'
     */
    protected function getRequestHeaders(bool $sendJson = false): array
    {
        $contentType = 'application/x-www-form-urlencoded';
        if ($sendJson){
            $contentType = 'application/json';
        }

        return [
            'Accept' => 'application/json',
            'Content-Type' => $contentType,
            'Authorization' => 'Bearer ' . $this->getApiKey()
        ];
    }

    protected function getExceptionByStatusCode(
        string $method,
        string $url,
        Response $response
    ): RequestException {
        $exceptions = [
            ForbiddenException::STATUS => ForbiddenException::class,
            BadRequestException::STATUS => BadRequestException::class,
        ];

        $class = $exceptions[$response->getStatus()] ?? RequestException::class;
        $e = new $class($method, $url, $response);
        return $e;
    }
}
