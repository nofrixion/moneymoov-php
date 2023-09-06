<?php

namespace Nofrixion\Model\PaymentRequests;

use DateTimeInterface;
use Nofrixion\Model\Merchant\Merchant;
use Nofrixion\Model\PaymentRequests\PaymentRequestResult;
use Ramsey\Uuid\UuidInterface;

class PaymentRequest
{
    public UuidInterface $id;
    public UuidInterface $merchantID;
    public string $amount;
    /** 
     * @var string Currency type: NONE | GBP | EUR | LBTC | BTC
     */
    public string $currency;
    public ?string $customerID;
    public ?string $orderID;
    /**
     * @var string Payment method type: None | card | pisp | lightning | cardtoken | applePay | googlePay
     */
    public ?string $paymentMethodTypes;
    public ?string $description;
    public ?UuidInterface $pispAccountID;
    public ?string $baseOriginUrl;
    public ?string $callbackUrl;
    public ?string $successWebHookUrl;
    public bool $cardAuthorizeOnly = false;
    public bool $cardCreateToken = false;
    /** 
     * @var string Mode for card token creation: None | ConsentNotRequired | UserConsentRequired 
     */
    public ?string $cardCreateTokenMode;
    public bool $ignoreAddressVerification = false;
    public bool $cardIgnoreCVN = false;
    public ?string $cardProcessorMerchantID;
    /** 
     * @var string Payment processor: None | CyberSource | Checkout | Stripe | Modulr | Plaid | Yapily | Nofrixion | Bitcoin | BitcoinTestnet 
     */
    public ?string $paymentProcessor;
    public ?string $pispRecipientReference;
    public ?string $lightningInvoice;
    /** 
     * @var string Payment request status: None | FullyPaid | PartiallyPaid | OverPaid | Voided | Authorized 
     */
    public ?string $status;
    public ?string $hostedPayCheckoutUrl;
    /**
     * @var string Partial payment method: None | Partial
     */
    public ?string $partialPaymentMethod;
    public ?DateTimeInterface $inserted;
    public ?string $insertedSortable;
    public ?DateTimeInterface $lastUpdated;
    public bool $UseHostedPaymentPage = false;
    public ?string $customerEmailAddress;
    public ?string $cardStripePaymentIntentID;
    public ?string $cardStripePaymentIntentSecret;

    /** @var list<PaymentRequestAddress> */
    public ?array $addresses;
    public ?array $events;
    public ?array $tokenisedCards;
    public ?array $transactions;
    public ?array $tags;
    public PaymentRequestResult $result;
    public ?string $jwk;
    public ?UuidInterface $priorityBankID;
    public ?string $title;
    public ?string $partialPaymentSteps;
    public ?PaymentRequestAddress $shippingAddress;
    public ?string $notificationEmailAddresses;
    public ?array $paymentAttempts;

    public ?string $failureCallbackUrl;
    public ?Merchant $merchant;
    public ?float $amountReceived;
    public ?float $amountRefunded;
    public ?float $amountPending;

}
