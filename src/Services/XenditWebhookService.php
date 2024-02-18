<?php

namespace App\Services;

use Bagene\PhPayments\Xendit\XenditWebhook;
use Bagene\PhPayments\Xendit\XenditWebhookInterface;
use Illuminate\Http\Response;

class XenditWebhookService extends XenditWebhook implements XenditWebhookInterface
{
    /**
     * @inheritDoc
     */
    public function handle(array $payload): ?Response
    {
        // TODO: Implement updateStatus() method.
        // add your transactions after parsing webhook here
        return null;
    }
}
