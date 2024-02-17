## Installation
```bash
composer require "bagene/ph-payments"
```

## Laravel Assets
```bash
php artisan vendor:publish --provider="Bagene\PhPayments\PhPaymentsServiceProvider"
```

## Configuration
```bash
php artisan vendor:publish --provider="Bagene\PhPayments\PhPaymentsServiceProvider" --tag="config"
```

## Usage
```php
use Bagene\PhPayments\Helpers\PaymentBuilder;

$gateway = PaymentBuilder::setGateway('xendit');

$response = $gateway->createInvoice([
    'external_id' => 'invoice-123',
    'amount' => 100000,
    'payer_email' => 'test@example.org',
    'description' => 'Invoice #123',
    'success_redirect_url' => 'https://example.org/success',
    'failure_redirect_url' => 'https://example.org/failure',
]);

dump($response->getId());
dump($response->getExternalId());

return redirect()->away($response->getInvoiceUrl());
```

## Methods

```php
createInvoice(array $data)
getInvoice(string $id)
createQrCode(string $id) - If supported
```

## Webhooks
- Under Construction

## Supported Gateways
- Xendit 
  - Supported Features: 
    - Create Invoice
    - Get Invoice
    - Create QR Code
    - Webhooks
- Maya - Under Consstruction

## License
This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
