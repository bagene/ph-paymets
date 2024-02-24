<?php

namespace Bagene\PhPayments\Controllers;

use Bagene\PhPayments\PaymentGateway;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Bagene\PhPayments\Xendit\XenditWebhookInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class XenditWebhookController extends Controller implements WebhookControllerInterface
{
    protected XenditGatewayInterface $gateway;
    protected XenditWebhookInterface $webhook;
    public function __construct()
    {
        /** @var XenditGatewayInterface $gateway */
        $gateway = app(XenditGatewayInterface::class);
        $this->gateway = $gateway;

        /** @var XenditWebhookInterface $webhook */
        $webhook = app(XenditWebhookInterface::class);
        $this->webhook = $webhook;
    }

    /**
     * @inheritDoc
     */
    public function parse(Request $request): mixed
    {
        $data = $this->gateway->parseWebhookPayload($request);

        return $this->webhook->handle($data);
    }
}
