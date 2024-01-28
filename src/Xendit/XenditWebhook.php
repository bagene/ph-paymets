<?php

namespace Bagene\PhPayments\Xendit;

use Bagene\PhPayments\WebhookInterface;
use Illuminate\Http\Response;

abstract class XenditWebhook implements XenditWebhookInterface
{
    abstract public function updateStatus($payload): void;
}
