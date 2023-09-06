<?php

declare(strict_types=1);

namespace Nofrixion\Model\PaymentRequests;

use Nofrixion\Util\PreciseNumber;
use Ramsey\Uuid\UuidInterface;

class PaymentRequestCreate
{
    public UuidInterface $merchantID;
    public string $amount;
    public string $currency;
    public ?string $CustomerID;
    public ?string $OrderID;
    public string $paymentMethodTypes;
    public ?string $description;
    public ?UuidInterface $pispAccountID;
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
    public ?bool $cardAuthorizeOnly;
    public ?bool $cardCreateToken;
    public ?string $cardCreateTokenMode;
    public ?bool $cardTransmitRawDetails;
    public ?string $cardProcessorMerchantID;
    public ?bool $ignoreAddressVerification;
    public ?bool $cardIgnoreCVN;
    public ?string $pispRecipientReference;
    public ?bool $useHostedPaymentPage;
    public ?bool $cardNoPayerAuthentication;
    public ?string $partialPaymentMethod;
    public ?string $customerEmailAddress;
    public ?string $paymentProcessor;
    public ?string $lightningInvoice;
    public ?string $notificationEmailAddresses;
    public ?UuidInterface $priorityBankID;
    public ?string $title;
    public ?string $partialPaymentSteps;
    public ?array $tags;

}
