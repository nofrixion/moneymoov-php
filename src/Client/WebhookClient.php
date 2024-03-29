<?php

declare(strict_types=1);

namespace Nofrixion\Client;

use Nofrixion\Client\AbstractClient;
use Nofrixion\Model\Webhook;
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
     * @return Webhook
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
            $responseArray = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $webhook = new Webhook(
                // 'id' can only be null when using 'createWebhook' method.
                $responseArray['id'],
                $webhook->merchantId,
                $responseArray['type'],
                $responseArray['destinationUrl'],
                $responseArray['retry'] ?? null,
                $responseArray['secret'],
                $responseArray['isActive'] ?? null,
                $responseArray['emailAddress'] ?? null
            );
            //return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            return $webhook;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/get_api-v1-webhooks-merchantid
     * @param string $merchantId The merchant Id for whom to retrieve webhooks
     * 
     * @return array An array of Webhook objects
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
     * @param Webhook $webhook The Id of the webhook to be updated
     * 
     * @return Webhook
     */
    public function updateWebhook(Webhook $webhook): Webhook
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
            $responseArray = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $webhook = new Webhook(
                // 'id' can only be null when using 'createWebhook' method.
                $responseArray['id'],
                $webhook->merchantId,
                $responseArray['type'],
                $responseArray['destinationUrl'],
                $responseArray['retry'] ?? null,
                $responseArray['secret'],
                $responseArray['isActive'] ?? null,
                $responseArray['emailAddress'] ?? null
            );
            //return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            return $webhook;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }
}

//EOF
