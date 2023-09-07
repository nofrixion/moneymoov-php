<?php

declare(strict_types=1);

namespace Nofrixion\Model\PaymentRequests;

class PaymentRequestResult
{
    public string $paymentRequestID;
    public string $amount;
    public string $currency;
    public string $result;
    public string $requestedAmount;
    public ?array $payments;
    public ?array $pispAuthorizations;
    public ?string $customerID;

    public function __construct(
        string $paymentRequestID,
        string $amount,
        string $currency,
        string $result,
        string $requestedAmount,
        ?array $payments,
        ?array $pispAuthorizations,
        ?string $customerID
    ) {
        $this->paymentRequestID = $paymentRequestID;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->result = $result;
        $this->requestedAmount = $requestedAmount;
        $this->payments = $payments;
        $this->pispAuthorizations = $pispAuthorizations;
        $this->customerID = $customerID;
        
    }
}