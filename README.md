# moneymoov-php #

NoFrixion MoneyMoov PHP client library. 

The latest library updates have been released as version 3.0.0 of the library. New models and clients/client methods have been added to support additional MoneyMoov API endpoints. 

- Continue using `v1.x.x` of this library if using `v1.x.x` of either the NoFrixion [`woocommerce-plugin`](https://github.com/nofrixion/woocommerce-plugin) or the [`magento2-payments-module`](https://github.com/nofrixion/magento2-payment-module).
- Continue using `v2.0.0` of this library if using `v2.0.0` of the NoFrixion [`magento2-payments-module`](https://github.com/nofrixion/magento2-payment-module).

## Installation ##

To use the library in your project, run:

```bash
composer require nofrixion/moneymoov-php
```

## Usage ##

The following example code shows how to use the library to create, update and delete payment requests (see the [NoFrixion API documentation](https://docs.nofrixion.com/reference/sandbox) for a full MoneyMoov API reference and instructions on signing up for a sandbox account).

```php
// Client for handling Payment Request API endpoints
use Nofrixion\Client\PaymentRequestClient;

// Models for creating/updating Payment Requests
use Nofrixion\Model\PaymentRequests\PaymentRequestCreate;
use Nofrixion\Model\PaymentRequests\PaymentRequestUpdate;

// Model returned by payment request client on creation/update
use Nofrixion\Model\PaymentRequests\PaymentRequest;

use Nofrixion\Util\PreciseNumber;

$apiUrl = "https://api-sandbox.nofrixion.com/";
// A merchant token can be used for creating and modifying payment requests - this MUST be securely stored.
$token = getenv("MERCHANT_TOKEN_SANDBOX");

$client = new PaymentRequestClient($apiUrl, $token);

// Creating a Payment request (payment amount is required).
$amount = new PreciseNumber("1.11");
$newPaymentRequest = new PaymentRequestCreate($amount->__toString());

// Additional optional fields can be set directly on PaymentRequestCreate model.
$newPaymentRequest->shippingFirstName = "Customer";
$newPaymentRequest->shippingLastName = "Name";
$newPaymentRequest->baseOriginUrl = "https://store.example.com";

// A PaymentRequest model is returned
$result = $client->createPaymentRequest($newPaymentRequest);


// UPDATES: use the PaymentRequestUpdate model to update payment request values.
$update = new PaymentRequestUpdate();
$update->paymentMethodTypes = 'card, pisp';
$update->amount = "1.45";
$update->shippingAddressCity = "Dublin";
$result = $client->updatePaymentRequest($result->id, $update);


// DELETING a payment request
$deleted = $client->deletePaymentRequest($result->id);
```
