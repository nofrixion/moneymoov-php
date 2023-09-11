<?php

declare(strict_types=1);

namespace Nofrixion\Model\PaymentRequests;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class PaymentRequestAddress
{
    public ?string $id;
    public ?string $paymentRequestID;
    /**
     * @var string Address type: Unknown | Shipping | Billing
     */
    public ?string $addressType;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $addressLine1;
    public ?string $addressLine2;
    public ?string $addressCity;
    public ?string $addressCounty;
    public ?string $addressPostCode;
    public ?string $addressCountryCode;
    public ?string $phone;
    public ?string $email;
    public ?string $inserted;
    public ?string $lastUpdated;

    public function __construct(
        ?array $addressFields
    ) {
        foreach ($addressFields as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
