<?php

namespace Bagene\PhPayments\Tests;

use Illuminate\Foundation\Application;
use JetBrains\PhpStorm\NoReturn;
use \Orchestra\Testbench\TestCase;

class PaymentsTestCase extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    #[NoReturn] protected function defineEnvironment($app): void
    {
        $this->mergeEnvironmentConfig($app);
    }

    protected function mergeEnvironmentConfig($app): void
    {
        $config = require __DIR__ . '/../src/config/payments.php';

        foreach ($config as $key => $value) {
            $app['config']->set("payments.$key", array_merge(
                $value,
                $app['config']->get("payments.$key", []),
            ));
        }
    }
}
