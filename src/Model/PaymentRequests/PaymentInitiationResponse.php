<?php

declare(strict_types=1);

namespace Nofrixion\Model\PaymentRequests;

use \RuntimeException;

/**
 * Returns a payment initiation response that contains the payment ID and the payment link.
 */
class PaymentInitiationResponse 
{
    /**
     * The unique identifier of the payment initiation request.
     * @var string | null 
     */
    public ?string $paymentInitiationId;
    /**
     * A redirect URL for the user to authorize the payment initiation request at the ASPSP
     * @var string | null 
     */
    public ?string $redirectUrl;

    /**
     * If Plaid is being used for the payment initiation this will contain the token
     * for the Plaid link client.
     * @var string | null 
     */
    public ?string $plaidLinkToken;

    /**
     * Summary of specificErrorMessage
     * @var string | null 
     */
    public ?string $specificErrorMessage;
    /**
     * The callback URL that was set when the payment request was created. Payers will be
     * redirected to this URL after a successful payment initiation.
     * @var string | null
     */
    public ?string $paymentRequestCallbackUrl;
    /**
     * Summary of paymentRequestID
     * @var string
     */
    public string $paymentRequestID;
    /**
     * Summary of responseType: 
     * None | CardPayerAuthenticationSetupResponse | CardPaymentResponse | PaymentInitiationResponse
     * @var string
     */
    public string $responseType;

    
}
