<?php

declare(strict_types=1);

namespace Nofrixion\Client;

use Nofrixion\Model\PaymentRequests\PaymentInitiationResponse;
use Nofrixion\Util\PreciseNumber;

class PaymentRequestClient extends AbstractClient
{
    /**
     * @see https://docs.nofrixion.com/reference/post_api-v1-paymentrequests
     */
    public function createPaymentRequest(
        string $originUrl,
        string $callbackUrl,
        PreciseNumber $amount,
        string $customerEmailAddress,
        ?string $currency = null,
        ?array $paymentMethodTypes = null,
        ?string $orderId = null,
        ?bool $createToken = false,
        ?string $customerId = null,
        ?bool $cardAuthorizeOnly = false,
        bool $showBillingAddressSameAsShippingAddressCheckbox = false,
        ?string $successWebHookUrl = null
    ): array {
        $url = $this->getApiUrl() . 'paymentrequests';
        $headers = $this->getRequestHeaders();
        $method = 'POST';

        if (is_array($paymentMethodTypes)) {
            $paymentMethodTypes = implode(',', $paymentMethodTypes);
        }

        $body = http_build_query([
            'Amount' => $amount->__toString(),
            'Currency' => $currency,
            'OriginUrl' => $originUrl,
            'CallbackUrl' => $callbackUrl,
            'PaymentMethodTypes' => $paymentMethodTypes,
            'OrderID' => $orderId,
            'CardCreateToken' => $createToken && $customerEmailAddress != "" ? 'true' : 'false',
            'CustomerID' => $customerId ?? '',
            'CardAuthorizeOnly' => $cardAuthorizeOnly ? 'true' : 'false',
            'CustomerEmailAddress' => $customerEmailAddress,
            'IgnoreAddressVerification' => $showBillingAddressSameAsShippingAddressCheckbox ? 'false' : 'true',
            'SuccessWebHookUrl' => $successWebHookUrl
        ]);

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if (in_array($response->getStatus(), [200, 201], true)) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/delete_api-v1-paymentrequests-id
     */
    public function deletePaymentRequest(
        string $paymentRequestId
    ): array {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId);
        $headers = $this->getRequestHeaders();
        $method = 'DELETE';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/put_api-v1-paymentrequests-id
     */
    public function updatePaymentRequest(
        string $paymentRequestId,
        string $originUrl,
        string $callbackUrl,
        PreciseNumber $amount,
        ?string $currency = null,
        ?array $paymentMethodTypes = null,
        ?string $orderId = null,
        ?bool $createToken = false,
        ?string $customerId = null,
        ?bool $cardAuthorizeOnly = false,
        ?string $customerEmailAddress = null
    ): array {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId);
        $headers = $this->getRequestHeaders();
        $method = 'PUT';

        $body = http_build_query([
            'Amount' => $amount->__toString(),
            'Currency' => $currency,
            'OriginUrl' => $originUrl,
            'CallbackUrl' => $callbackUrl,
            'PaymentMethodTypes' => implode(',', $paymentMethodTypes),
            //'OrderID' => $orderId,
            'CardCreateToken' => $createToken && $customerEmailAddress !== "" && $customerEmailAddress !== null ? 'true' : 'false',
            'CustomerID' => $customerId ?? '',
            'CardAuthorizeOnly' => $cardAuthorizeOnly ? 'true' : 'false',
            'CustomerEmailAddress' => $customerEmailAddress
        ]);

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if (in_array($response->getStatus(), [200, 201], true)) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/get_api-v1-paymentrequests-id
     */
    public function getPaymentRequest(
        string $paymentRequestId
    ): array {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId);
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/get_api-v1-paymentrequests-getbyorderid-orderid
     */
    public function getPaymentRequestByOrderId(
        string $orderId
    ): array {
        $url = $this->getApiUrl() . 'paymentrequests/getbyorderid/' . urlencode($orderId);
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }


    /**
     * @see https://docs.nofrixion.com/reference/get_api-v1-paymentrequests-id-result
     */
    public function getPaymentRequestResult(
        string $paymentRequestId
    ): array {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId) . '/result';
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * initiatePayByBank - Submits a payment initiation request.
     * @param string $paymentRequestId
     * @param string $bankId
     * @return \Nofrixion\Model\PaymentRequests\PaymentInitiationResponse
     */
    public function initiatePayByBank(
        string $paymentRequestId,
        string $bankId,
        ?string $redirectToOriginUrl,
        ?PreciseNumber $amount
    ): PaymentInitiationResponse {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId) . '/pisp';
        $headers = $this->getRequestHeaders();
        $method = 'POST';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if (!is_null($amount)) {
            $amount = $amount->__toString();
        }
        $body = http_build_query([
            'ProviderID' => $bankId,
            'PartialAmount' => $amount,
            'RedirectToOriginUrl' => $redirectToOriginUrl
        ]);

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if (in_array($response->getStatus(), [200, 201], true)) {
            $responseBody = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            // return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            
            $paymentInitiationResponse = new PaymentInitiationResponse();

            $paymentInitiationResponse->paymentRequestID = $responseBody['paymentRequestID'];
            $paymentInitiationResponse->responseType = $responseBody['responseType'];
            $paymentInitiationResponse->paymentInitiationId = $responseBody['paymentInitiationID'] ?? null;
            $paymentInitiationResponse->paymentRequestCallbackUrl = $responseBody['paymentRequestCallbackUrl'] ?? null;
            $paymentInitiationResponse->plaidLinkToken = $responseBody['plaidLinkToken'] ?? null;
            $paymentInitiationResponse->redirectUrl = $responseBody['redirectUrl'] ?? null;
            $paymentInitiationResponse->specificErrorMessage = $responseBody['specificErrorMessage'] ?? null;

            return $paymentInitiationResponse;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/post_api-v1-paymentrequests-id-card-paywithtoken
     */
    public function payWithCardToken(
        string $paymentRequestId,
        string $tokenisedCardId
    ): array {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId) . '/card/paywithtoken';
        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = http_build_query([
            'TokenisedCardID' => $tokenisedCardId
        ]);

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if (in_array($response->getStatus(), [200, 201], true)) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/get_api-v1-paymentrequests-card-customertokens-customerid
     */
    public function getCustomerTokenisedCards(string $customerId): array
    {
        $url = $this->getApiUrl() . 'paymentrequests/card/customertokens/' . urlencode($customerId);
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/post_api-v1-paymentrequests-id-pisp
     * @deprecated 2.0.0 No longer used by internal code and not recommended.
     */
    public function submitPaymentInitiationRequest(
        string $paymentRequestId,
        string $providerId
    ): array {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId) . '/pisp';
        $headers = $this->getRequestHeaders();
        $method = 'POST';

        $body = http_build_query([
            'ProviderID' => $providerId
        ]);

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if (in_array($response->getStatus(), [200, 201], true)) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }


    /**
     * @see https://docs.nofrixion.com/reference/post_api-v1-paymentrequests-id-card-voidpaymentrequest
     */
    public function voidAllPaymentsForPaymentRequest(string $paymentRequestId): array
    {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId) . '/card/voidpaymentrequest';
        $headers = $this->getRequestHeaders();
        $method = 'POST';
        $body = http_build_query([]);
        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if (in_array($response->getStatus(), [200, 201], true)) {
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }
}