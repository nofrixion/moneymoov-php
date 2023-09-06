<?php

declare(strict_types=1);

namespace Nofrixion\Model\PaymentRequests;

use Nofrixion\Util\PreciseNumber;
use Ramsey\Uuid\UuidInterface;

class PaymentRequestResult
{
    public UuidInterface $paymentRequestID;
    public string $amount;
    public string $currency;
    public string $cusomterID;
    public string $result;
    public string $requestedAmount;
    public ?array $payments;
    public ?array $pispAuthorizations;
    
}