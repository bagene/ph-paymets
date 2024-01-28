<?php

namespace App\Services;

use Bagene\PhPayments\Xendit\XenditWebhook;
use Bagene\PhPayments\Xendit\XenditWebhookInterface;

class XenditWebhookService extends XenditWebhook implements XenditWebhookInterface
{
    public function handle($payload): void
    {
        // TODO: Implement updateStatus() method.
        // add your transactions after parsing webhook here
    }
}
