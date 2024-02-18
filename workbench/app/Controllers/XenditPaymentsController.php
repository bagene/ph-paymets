<?php

namespace Workbench\App\Controllers;

use Bagene\PhPayments\Helpers\PaymentBuilder;
use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class XenditPaymentsController extends Controller
{
    public function createPayment(Request $request): RedirectResponse
    {
        $data = $request->all();

        $gateway = PaymentBuilder::setGateway('xendit');

        /** @var XenditInvoiceResponse $response */
        $response = $gateway->createInvoice($data);

        return redirect()->away($response->getInvoiceUrl());
    }

    public function getPayment(): JsonResponse
    {
        $gateway = PaymentBuilder::setGateway('xendit');

        $response = $gateway->getInvoice('123');

        return response()->json($response->getBody());
    }
}
