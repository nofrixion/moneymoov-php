<?php
declare(strict_types=1);

namespace NoFrixion\Client;

use NoFrixion\Client\AbstractClient;

class Webhook extends AbstractClient
{
    public function createWebhook(
        string $merchantId,
        string $type,
        string $destinationUrl,
        ?bool $retry = null,
        string $secret,
        ?bool $isActive = true,
        ?string $emailAddress = null
    ): string {
        $url = $this->getApiUrl() . 'webhooks';
        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = http_build_query([
            'MerchantID' => $merchantId,
            'Type' => $type,
            'DestinationUrl' => $destinationUrl,
            'Retry' => $retry ? 'true' : 'false',
            'Secret' => $secret,
            'IsActive' => $isActive ? 'true' : 'false',
            'EmailAddress' => $emailAddress ?? ''
        ]);
        try {
            $response = $this->getHttpClient()->request($method, $url, $headers, $body);

            if (in_array($response->getStatus(), [200, 201], true)) {
                //return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
                return $response->getBody();
            } else {
                throw $this->getExceptionByStatusCode($method, $url, $response);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getWebhooks(string $merchantId): string
    {
        $url = $this->getApiUrl() . 'webhooks/' . $merchantId;
        $headers = $this->getRequestHeaders();
        $method = 'GET';

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            //return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            return $response->getBody();
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    public function updateWebhook(
        string $id,
        string $merchantId,
        string $type,
        string $destinationUrl,
        ?bool $retry = null,
        string $secret,
        ?bool $isActive = true,
        ?string $emailAddress = null
    ): string {
        $url = $this->getApiUrl() . 'webhooks/' . $id;
        $headers = $this->getRequestHeaders();
        $method = 'PUT';

        $body = http_build_query([
            'MerchantID' => $merchantId,
            'Type' => $type,
            'DestinationUrl' => $destinationUrl,
            'Retry' => $retry ?? '',
            'Secret' => $secret,
            'IsActive' => $isActive ?? '',
            'EmailAddress' => $emailAddress ?? ''
        ]);

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);
        if (in_array($response->getStatus(), [200, 201], true)) {
            //return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            return $response->getBody();
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

}