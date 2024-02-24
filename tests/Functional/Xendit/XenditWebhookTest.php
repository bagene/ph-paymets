<?php

namespace Bagene\PhPayments\Tests\Functional\Xendit;

use Bagene\PhPayments\Tests\ShouldMock;
use Bagene\PhPayments\Xendit\XenditWebhookInterface;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Workbench\App\Models\TestOrder;
use Workbench\App\Services\XenditWebhookService;

use function Orchestra\Testbench\artisan;
use function Orchestra\Testbench\workbench_path;

use Orchestra\Testbench\Attributes\WithMigration;

#[WithMigration]
class XenditWebhookTest extends TestCase
{
    use WithWorkbench, ShouldMock, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        config(['payments.xendit.webhook_token' => 'token']);
        $this->app->bind(XenditWebhookInterface::class, XenditWebhookService::class);
    }

    public function tearDown(): void
    {
        Cache::flush();
    }

    protected function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        tap($app['config'], function (Repository $config) {
            $config->set('database.default', 'testbench');
            $config->set('database.connections.testbench', [
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ]);
        });
    }

    protected function defineRoutes($router): void
    {
        $router->post('/api/xendit/webhook', [
            'uses' => 'Bagene\PhPayments\Controllers\XenditWebhookController@parse',
        ]);
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(workbench_path('database/migrations'));
        artisan($this, 'migrate', ['--database' => 'testbench']);
    }

    public function testXenditWebhook(): void
    {
        TestOrder::create([
            'amount' => 100,
            'status' => 'pending',
            'reference' => '123',
        ]);

        $response = $this->post('/api/xendit/webhook', [
            'id' => '123',
            'status' => 'PAID',
            'external_id' => '123',
            'webhook-id' => 1,
        ], [
            'X-CALLBACK-TOKEN' => 'token',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'ok',
        ]);
        $this->assertTrue(Cache::has('xendit-webhook-1'));

        /** @var TestOrder $order */
        $order = TestOrder::query()
            ->where('reference', '123')
            ->first();

        $this->assertEquals('paid', $order->status);
    }

    public function testXenditWebhookWithInvalidToken(): void
    {
        TestOrder::create([
            'amount' => 100,
            'status' => 'pending',
            'reference' => '123',
        ]);

        $response = $this->post('/api/xendit/webhook', [
            'id' => '123',
            'status' => 'PAID',
            'external_id' => '123',
            'webhook-id' => 1,
        ], [
            'X-CALLBACK-TOKEN' => 'invalid-token',
        ]);

        $response->assertStatus(500);
        $this->assertFalse(Cache::has('xendit-webhook-1'));

        /** @var TestOrder $order */
        $order = TestOrder::query()
            ->where('reference', '123')
            ->first();

        $this->assertEquals('pending', $order->status);
    }
}
