<?php

namespace Bagene\PhPayments\Tests;

use App\Services\XenditWebhookService;
use Bagene\PhPayments\Maya\MayaGateway;
use Bagene\PhPayments\Maya\MayaGatewayInterface;
use Bagene\PhPayments\Xendit\XenditGateway;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Bagene\PhPayments\Xendit\XenditWebhookInterface;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected function getEnvironmentSetUp($app)
    {
        $app->bind(XenditGatewayInterface::class, XenditGateway::class);
        $app->bind(XenditWebhookInterface::class, XenditWebhookService::class);
        $app->bind(MayaGatewayInterface::class, MayaGateway::class);
    }
}
