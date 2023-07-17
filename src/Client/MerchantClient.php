<?php

declare(strict_types=1);

namespace Nofrixion\Client;

use Nofrixion\Model\Merchant\Merchant;
use Nofrixion\Model\Merchant\MerchantPayByBankSetting;
use Nofrixion\Model\Merchant\MerchantPayByBankSettings;
use \RuntimeException;


/**
 * MerchantClient enables calls to MoneyMoov API `merchant/` endpoints
 */
class MerchantClient extends AbstractClient
{

    /**
     * getMerchantPayByBankSettings returns an array of MerchantPayByBankSetting objects.
     * @param string $merchantId
     * @return array 
     */
    public function getMerchantPayByBankSettings(string $merchantId): array
    {
        $url = $this->getApiUrl() . 'merchants/' . $merchantId . '/banksettings';
        $headers = $this->getRequestHeaders();
        $method = 'GET';

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
            // $merchantPayByBankSettings = new MerchantPayByBankSettings(
            //     $response['merchantID'], 
            //     $payByBankSettingsArray
            // );
            return $payByBankSettingsArray;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }
    /**
     * whoAmIMerchant returns details of the merchant that was issued the API token used in the request.
     * @return \Nofrixion\Model\Merchant\Merchant
     */
    public function whoAmIMerchant(): Merchant
    {
        $url = $this->getApiUrl() . 'metadata/whoamimerchant';
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        // $webhookArray = array();

        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            // $response is an associative array representing the merchant.
            $responseBody = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $merchant = new Merchant(
                $responseBody['id'],
                $responseBody['name'] ?? null,
                $responseBody['enabled'],
                $responseBody['companyId'] ?? null,
                $responseBody['merchantCategoryCode'],
                $responseBody['shortName'] ?? null,
                $responseBody['tradingName'] ?? null,
                $responseBody['paymentAccountLimit'],
                $responseBody['inserted'],
                $responseBody['jurisdiction'],
                $responseBody['hostedPayVersion'],
                $responseBody['webhookLimit'] ?? null,
                $responseBody['displayQrOnHostedPay'],
                $responseBody['yourRole'],
                $responseBody['userRoles'],
                $responseBody['tags'],
                $responseBody['paymentAccounts']
            );
            return $merchant;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

}

//EOF
