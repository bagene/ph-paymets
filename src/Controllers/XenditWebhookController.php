<?php

namespace Bagene\PhPayments\Controllers;

use Bagene\PhPayments\WebhookInterface;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Bagene\PhPayments\Xendit\XenditWebhookInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class XenditWebhookController extends Controller implements WebhookControllerInterface
{
    protected XenditGatewayInterface $gateway;
    protected XenditWebhookInterface $webhook;
    public function __construct(XenditGatewayInterface $gateway, XenditWebhookInterface $webhook)
    {
        $this->gateway = $gateway;
        $this->webhook = $webhook;
    }
    public function parse(Request $request)
    {
        $data = $this->gateway->parseWebhookPayload($request);

        $this->webhook->updateStatus($data);
    }
}
