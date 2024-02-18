<?php

namespace Bagene\PhPayments\Tests\Integration\config;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @param Application $app
     */
    protected function defineEnvironment($app): void
    {
        tap($app['config'], function ($config) {
            $config->set('payments', include __DIR__ . '/../../../src/config/payments.php');
        });
    }

    public function testConfigShouldBeLoaded(): void
    {
        $this->assertIsArray(config('payments'));
        $this->assertArrayHasKey('xendit', config('payments'));
    }
}
