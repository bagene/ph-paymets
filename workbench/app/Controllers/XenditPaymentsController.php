<?php

namespace Workbench\App\Controllers;

use Bagene\PhPayments\Exceptions\MethodNotFoundException;
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

        /** @var XenditInvoiceResponse $response */
        try {
            $response = PaymentBuilder::xendit()
                ->invoice()
                ->create($data);
        } catch (MethodNotFoundException $e) {
            // Log error
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->away($response->getInvoiceUrl());
    }

    public function getPayment(): JsonResponse
    {
        $response = PaymentBuilder::xendit()
            ->invoice()
            ->get(['id' => '123']);

        return response()->json($response->getBody());
    }
}
