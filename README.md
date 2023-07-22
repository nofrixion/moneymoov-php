# moneymoov-php #

NoFrixion MoneyMoov PHP client library. 

The latest library updates have been released as version 2.0.0 of the library. New models and clients/client methods have been added to support additional MoneyMoov API endpoints. In order to improve class naming consistency the `PaymentRequest` class has been renamed to `PaymentRequestClient` which will require code updates from applications using the version 1.x.x releases.

## Installation ##

To use the library in your project, run:

```bash
composer require nofrixion/moneymoov-php
```

## Usage ##

Use of the [create payment request endpoint](https://docs.nofrixion.com/reference/post_api-v1-paymentrequests):

```php
try {
    $client = new PaymentRequest( $apiUrl, $apiMerchantToken );
    $result = $client->createPaymentRequest(
        $originUrl,
        $callbackUrl,
        $amount,
        $customerEmailAddress,
        $currency,
        $paymentMethodTypes,
        $orderId,
        $createToken,
        $customerId,
        $cardAuthorizeOnly
    );

    // Process the result.

} catch ( \Throwable $e ) {
    // Catch the exception and log it.
}
```
