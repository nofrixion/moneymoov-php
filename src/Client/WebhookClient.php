<?php

declare(strict_types=1);

namespace NoFrixion\Client;

use NoFrixion\Client\AbstractClient;
use NoFrixion\Model\Webhook;
use \RuntimeException;

/**
 * Webhook: provides convenient PHP access to the MoneyMoov API 'webhook' endpoints.
 */
class WebhookClient extends AbstractClient
{

    /**
     * @see https://docs.nofrixion.com/reference/post_api-v1-webhooks
     * @param Webhook $webhook
     * 
     * @return Webhook associative array of JSON response
     */
    public function createWebhook(Webhook $webhook): Webhook
    {
        $url = $this->getApiUrl() . 'webhooks';
        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = http_build_query([
            'MerchantID' => $webhook->merchantId,
            'Type' => $webhook->type,
            'DestinationUrl' => $webhook->destinationUrl,
            'Retry' => $webhook->retry ? 'true' : 'false',
            'Secret' => $webhook->secret,
            'IsActive' => $webhook->isActive ? 'true' : 'false',
            'EmailAddress' => $webhook->emailAddress ?? ''
        ]);
        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if (in_array($response->getStatus(), [200, 201], true)) {
            $webhook = new Webhook(
                // 'id' can only be null when using 'createWebhook' method.
                $response['id'],
                $$webhook->merchantId,
                $response['type'],
                $response['destinationUrl'],
                $response['retry'] ?? null,
                $response['secret'],
                $response['isActive'] ?? null,
                $response['emailAddress'] ?? null
            );
            //return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            return $webhook;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/get_api-v1-webhooks-merchantid
     */
    public function getWebhooks(string $merchantId): array
    {
        $url = $this->getApiUrl() . 'webhooks/' . $merchantId;
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $webhookArray = array();

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            // $responses is an indexed array of associative arrays, each one representing a webhook.
            $responses = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            foreach ($responses as $responseItem) {
                $webhook = new Webhook(
                    // 'id' can only be null when using 'createWebhook' method.
                    $responseItem['id'],
                    $merchantId,
                    $responseItem['type'],
                    $responseItem['destinationUrl'],
                    $responseItem['retry'] ?? null,
                    $responseItem['secret'],
                    $responseItem['isActive'] ?? null,
                    $responseItem['emailAddress'] ?? null
                );
                array_push($webhookArray, $webhook);
            }
            // return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            return $webhookArray;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/put_api-v1-webhooks-id
     */
    public function updateWebhook(Webhook $webhook): array
    {
        if (!is_null($webhook->id)) {
            $url = $this->getApiUrl() . 'webhooks/' . $webhook->id;
        } else {
            throw new RuntimeException('"null" $id specified. $id is required for updateWebhook().');
        }
        $headers = $this->getRequestHeaders();
        $method = 'PUT';

        $body = http_build_query([
            'MerchantID' => $webhook->merchantId,
            'Type' => $webhook->type,
            'DestinationUrl' => $webhook->destinationUrl,
            'Retry' => $webhook->retry ? 'true' : 'false',
            'Secret' => $webhook->secret,
            'IsActive' => $webhook->isActive ? 'true' : 'false',
            'EmailAddress' => $webhook->emailAddress ?? ''
        ]);

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);
        if (in_array($response->getStatus(), [200, 201], true)) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            //return $response->getBody();
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }
}

//EOF
