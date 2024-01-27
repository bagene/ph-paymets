<?php

namespace Bagene\PhPayments\Controllers;

use Bagene\PhPayments\WebhookInterface;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class XenditWebhookController extends Controller
{
    protected XenditGatewayInterface $gateway;
    protected XenditGatewayInterface $webhook;
    public function __construct()
    {
        $this->gateway = app(XenditGatewayInterface::class);

    }
    public function parse(Request $request)
    {
        $data = $this->gateway->parseWebhookPayload($request);

        return $this->gateway->updateStatus($data);
    }
}
