## Installation
```bash
composer require "bagene/ph-payments"
```

## Configuration
```bash
php artisan vendor:publish --tag="ph-payments-config"
```

## Usage
```php
use Bagene\PhPayments\Helpers\PaymentBuilder;

$gateway = PaymentBuilder::getMayaGateway();
$gateway = PaymentBuilder::getXendidGateway();

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
```php
use Bagene\PhPayments\Helpers\PaymentBuilder;

public function xenditWebhook(Request $request)
{
    $gateway = PaymentBuilder::getXendidGateway();
    $response = $gateway->parseWebhookPayload($request);
    
    // Do something with the response
}
```
Alternatively, you can use the `xendit-webhook` route and Controller to handle the webhook.
```
php artisan vendor:publish --tag=ph-payments-routes
php artisan vendor:publish --tag=ph-payments-services
```
After publishing the routes, you can add the route to your `routes/payments.php` file and the Service folder.
You can then use the `Services/WebhookService.php` to handle the webhook.

`routes/payments`
```php
<?php

use Bagene\PhPayments\Controllers\XenditWebhookController;
use Illuminate\Support\Facades\Route;

Route::post(
    '/webhooks/{provider}/invoice',
    [XenditWebhookController::class, 'parse']
)->name('xendit.invoice.create');
```
You can change the endpoint to you liking and register the route.

`Services/WebhookService.php`

```php
<?php

namespace App\Services;

use Bagene\PhPayments\Xendit\XenditWebhook;
use Bagene\PhPayments\Xendit\XenditWebhookInterface;
use Illuminate\Http\JsonResponse;
use App\Models\TestOrder;

class XenditWebhookService extends XenditWebhook implements XenditWebhookInterface
{

    public function handle(array $payload): JsonResponse
    {
        TestOrder::query()
            ->where('reference', $payload['external_id'])
            ->update([
                'status' => strtolower($payload['status'])
            ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}

```

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
