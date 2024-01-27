<?php

namespace Bagene\PhPayments;

use Illuminate\Support\ServiceProvider;

class PhPaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/payments.php' => config_path('payments.php'),
        ], 'config');
    }

    public function register()
    {
    }
}
