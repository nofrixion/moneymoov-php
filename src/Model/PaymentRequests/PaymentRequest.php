<?php

namespace Nofrixion\Model\PaymentRequests;

use Nofrixion\Model\PaymentRequests\PaymentRequestAddress;
use Nofrixion\Model\PaymentRequests\PaymentRequestResult;

/**
 * PaymentRequest - class for storing payment requests returned in MoneyMoov API response body.
 */
class PaymentRequest
{
    public string $id;
    public string $merchantID;
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
    public ?string $pispAccountID;
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
    public ?string $inserted;
    public ?string $insertedSortable;
    public ?string $lastUpdated;
    public bool $useHostedPaymentPage = false;
    public ?string $customerEmailAddress;
    public ?string $cardStripePaymentIntentID;
    public ?string $cardStripePaymentIntentSecret;

    /** 
     * @var array<PaymentRequestAddress>
     */
    public ?array $addresses;
    public ?array $events;
    public ?array $tokenisedCards;
    public ?array $transactions;
    public ?array $tags;
    public ?PaymentRequestResult $result;
    public ?string $jwk;
    public ?string $priorityBankID;
    public ?string $title;
    public ?string $partialPaymentSteps;
    public ?PaymentRequestAddress $shippingAddress;
    public ?string $notificationEmailAddresses;
    public ?array $paymentAttempts;

    public ?string $failureCallbackUrl;
    public ?string $amountReceived;
    public ?string $amountRefunded;
    public ?string $amountPending;

    public function __construct(
        string $responseBody
    ) {
        $json = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);

        foreach ($json as $key => $value) {
            switch ($key) {
                case "addresses":
                    /**  @ TODO convert this address array to array<PaymentRequestAddress> objects */
                    $this->addresses = $value;
                    break;
                case "result":
                    $this->result = new PaymentRequestResult(
                        $value['paymentRequestID'],
                        $value['amount'],
                        $value['currency'],
                        $value['result'],
                        $value['requestedAmount'],
                        $value['payments'],
                        $value['pispAuthorizations'],
                        $value['customerID']
                    );
                    break;
                case "shippingAddress":
                    $this->shippingAddress = new PaymentRequestAddress($value);
                    break;
                default:
                    $this->{$key} = $value;
            }
        }
    }
}
