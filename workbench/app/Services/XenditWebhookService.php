<?php

namespace Workbench\App\Services;

use Bagene\PhPayments\Xendit\XenditWebhook;
use Bagene\PhPayments\Xendit\XenditWebhookInterface;
use Illuminate\Http\JsonResponse;
use Workbench\App\Models\TestOrder;

class XenditWebhookService extends XenditWebhook implements XenditWebhookInterface
{
    /**
     * @param array{
     *  external_id: string,
     *  status: string
     * } $payload
     */
    public function handle(array $payload): JsonResponse
    {
        TestOrder::query()
            ->where('reference', $payload['external_id'])
            ->update([
                'status' => strtolower($payload['status'])
            ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
