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
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }

    public function register()
    {
    }
}
