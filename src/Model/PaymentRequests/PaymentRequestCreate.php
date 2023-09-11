<?php

declare(strict_types=1);

namespace Nofrixion\Model\PaymentRequests;

use Nofrixion\Util\PreciseNumber;

/**
 * PaymentRequestCreate - use to create payment request, at minimum MerchantID, amount, currency and paymentMethodTypes
 *  must be set in constructor. Other properties can be assigned direclty.
 */
class PaymentRequestCreate
{
    public string $merchantID;
    public string $amount;
    public string $currency;
    public string $paymentMethodTypes;
    public ?string $CustomerID;
    public ?string $OrderID;
    public ?string $description;
    public ?string $pispAccountID;
    public ?string $shippingFirstName;
    public ?string $shippingLastName;
    public ?string $shippingAddressLine1;
    public ?string $shippingAddressLine2;
    public ?string $shippingAddressCity;
    public ?string $shippingAddressCounty;
    public ?string $shippingAddressPostCode;
    public ?string $shippingAddressCountryCode;
    public ?string $shippingPhone;
    public ?string $shippingEmail;
    public ?string $baseOriginUrl;
    public ?string $callbackUrl;
    public ?string $failureCallbackUrl;
    public ?string $successWebHookUrl;
    public ?bool $cardAuthorizeOnly = false;
    public ?bool $cardCreateToken = false;
    public ?string $cardCreateTokenMode;
    public ?bool $cardTransmitRawDetails = false;
    public ?string $cardProcessorMerchantID;
    public ?bool $ignoreAddressVerification = false;
    public ?bool $cardIgnoreCVN = false;
    public ?string $pispRecipientReference;
    public ?bool $useHostedPaymentPage;
    public ?bool $cardNoPayerAuthentication = false;
    public ?string $partialPaymentMethod;
    public ?string $customerEmailAddress;
    public ?string $paymentProcessor;
    public ?string $lightningInvoice;
    public ?string $notificationEmailAddresses;
    public ?string $priorityBankID;
    public ?string $title;
    public ?string $partialPaymentSteps;
    public ?array $tags;

    public function __construct(
        string $merchantID,
        string $amount,
        string $currency = "EUR",
        string $paymentMethodTypes = "pisp"
    )
    {
        $this->merchantID = $merchantID;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->paymentMethodTypes = $paymentMethodTypes;
        
    }
}
