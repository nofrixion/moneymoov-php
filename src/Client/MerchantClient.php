<?php

declare(strict_types=1);

namespace NoFrixion\Client;

use NoFrixion\Client\AbstractClient;
use NoFrixion\Model\Merchant\Merchant;
use NoFrixion\Model\Merchant\MerchantPayByBankSetting;
use NoFrixion\Model\Merchant\MerchantPayByBankSettings;
use \RuntimeException;

/**
 * Webhook: provides convenient PHP access to the MoneyMoov API 'webhook' endpoints.
 */
class MerchantClient extends AbstractClient
{

    public function getMerchantPayByBankSettings(string $merchantId): MerchantPayByBankSettings
    {
        $url = $this->getApiUrl() . 'merchants/' . $merchantId . '/banksettings';
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        // $webhookArray = array();

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            // $response contains the merchantId and an array of associative arrays, each one representing a Pay by bank setting.
            $response = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $payByBankSettingsArray = array();
            
            foreach ($response['payByBankSettings'] as $pisp) {
                $payByBankSetting = new MerchantPayByBankSetting(
                    $pisp['bankID'],
                    $pisp['bankName'] ?? null,
                    $pisp['order'],
                    $pisp['logo'] ?? null,
                    $pisp['currency'],
                    $pisp['processor'] ?? null,
                    $pisp['personalInstitutionID'] ?? null,
                    $pisp['businessInstitutionID'] ?? null,
                    $pisp['message'] ?? null,
                    $pisp['messageImageUrl'] ?? null
                );
                array_push($payByBankSettingsArray, $payByBankSetting);
            }
            $merchantPayByBankSettings = new MerchantPayByBankSettings(
                $response['merchantID'], 
                $payByBankSettingsArray
            );
            return $merchantPayByBankSettings;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }
    public function whoAmIMerchant(): Merchant
    {
        $url = $this->getApiUrl() . 'metadata/whoamimerchant';
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        // $webhookArray = array();

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            // $response is an associative array representing the merchant.
            $body = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $merchant = new Merchant(
                $body['id'],
                $body['name'] ?? null,
                $body['enabled'],
                $body['companyId'] ?? null,
                $body['merchantCategoryCode'],
                $body['shortName'] ?? null,
                $body['tradingName'] ?? null,
                $body['paymentAccountLimit'],
                $body['inserted'],
                $body['jurisdiction'],
                $body['hostedPayVersion'],
                $body['webhookLimit'] ?? null,
                $body['displayQrOnHostedPay'],
                $body['yourRole'],
                $body['userRoles'],
                $body['tags'],
                $body['paymentAccounts']
            );
            return $merchant;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

}

//EOF
