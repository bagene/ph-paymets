<?php

namespace Bagene\PhPayments\Tests\Unit\Xendit;

use App\Services\XenditWebhookService;
use Orchestra\Testbench\PHPUnit\TestCase;

class XenditWebhookServiceTest extends TestCase
{
    public function testHandle(): void
    {
        $service = new XenditWebhookService();
        $payload = [];
        $this->assertNull($service->handle($payload));
    }
}
