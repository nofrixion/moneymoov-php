<?php

declare(strict_types=1);

namespace Nofrixion\Model\PaymentRequests;

use Nofrixion\Util\PreciseNumber;

/**
 * PaymentRequestUpdate - use to update a payment request.
 */
class PaymentRequestUpdate
{
    public ?string $amount;
    public ?string $currency;
    public ?string $paymentMethodTypes;
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
    public ?bool $cardAuthorizeOnly;
    public ?bool $cardCreateToken;
    public ?string $cardCreateTokenMode;
    public ?bool $ignoreAddressVerification;
    public ?bool $cardIgnoreCVN;
    public ?string $cardProcessorMerchantID;
    public ?string $customerEmailAddress;
    public ?string $notificationEmailAddresses;
    public ?string $title;
    public ?string $partialPaymentSteps;
    public ?array $tagIds;
}
