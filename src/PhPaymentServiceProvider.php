<?php

namespace Bagene\PhPayments;

use App\Services\XenditWebhookService;
use Bagene\PhPayments\Xendit\XenditGateway;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Bagene\PhPayments\Xendit\XenditWebhookInterface;
use Illuminate\Support\ServiceProvider;

class PhPaymentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/payments.php' => config_path('payments.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/routes/payments.php' => base_path('routes/payments.php'),
        ], 'routes');
        $this->publishes([
            __DIR__ . '/Services/' => app_path('Services/'),
        ], 'services');
    }

    public function register(): void
    {
        $this->app->bind(XenditGatewayInterface::class, XenditGateway::class);
        $this->app->bind(XenditWebhookInterface::class, XenditWebhookService::class);
    }
}
