<?php

declare(strict_types=1);

namespace Nofrixion\Client;

use Nofrixion\Model\PaymentRequests\PaymentInitiationResponse;
use Nofrixion\Model\PaymentRequests\PaymentRequest;
use Nofrixion\Model\PaymentRequests\PaymentRequestCreate;
use Nofrixion\Model\PaymentRequests\PaymentRequestUpdate;
use Nofrixion\Util\PreciseNumber;

class PaymentRequestClient extends AbstractClient
{
    /**
     * @see https://docs.nofrixion.com/reference/post_api-v1-paymentrequests
     */
    public function createPaymentRequest(
        PaymentRequestCreate $paymentRequest
    ): PaymentRequest {
        $url = $this->getApiUrl() . 'paymentrequests';
        $headers = $this->getRequestHeaders(true);
        $method = 'POST';
        //$body = http_build_query($paymentRequest);
        $body = json_encode($paymentRequest);

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if (in_array($response->getStatus(), [200, 201], true)) {
            $paymentRequest = new PaymentRequest($response->getBody());
            return $paymentRequest;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/delete_api-v1-paymentrequests-id
     */
    public function deletePaymentRequest(
        string $paymentRequestId
    ): bool {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId);
        $headers = $this->getRequestHeaders();
        $method = 'DELETE';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            return true;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/put_api-v1-paymentrequests-id
     */
    public function updatePaymentRequest(
        string $paymentRequestId,
        PaymentRequestUpdate $paymentRequest
    ): PaymentRequest {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId);
        $headers = $this->getRequestHeaders(true);
        $method = 'PUT';

        //$body = http_build_query($paymentRequest);
        $body = json_encode($paymentRequest);

        $response = $this->getHttpClient()->request($method, $url, $headers, $body);

        if (in_array($response->getStatus(), [200, 201], true)) {
            // return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $paymentRequest = new PaymentRequest($response->getBody());
            return $paymentRequest;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/get_api-v1-paymentrequests-id
     */
    public function getPaymentRequest(
        string $paymentRequestId
    ): PaymentRequest {
        $url = $this->getApiUrl() . 'paymentrequests/' . urlencode($paymentRequestId);
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            // return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $paymentRequest = new PaymentRequest($response->getBody());
            return $paymentRequest;
        } else {
            throw $this->getExceptionByStatusCode($method, $url, $response);
        }
    }

    /**
     * @see https://docs.nofrixion.com/reference/get_api-v1-paymentrequests-getbyorderid-orderid
     */
    public function getPaymentRequestByOrderId(
        string $orderId
    ): PaymentRequest {
        $url = $this->getApiUrl() . 'paymentrequests/getbyorderid/' . urlencode($orderId);
        $headers = $this->getRequestHeaders();
        $method = 'GET';
        $response = $this->getHttpClient()->request($method, $url, $headers);

        if ($response->getStatus() === 200) {
            // return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $paymentRequest = new PaymentRequest($response->getBody());
            return $paymentRequest;
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