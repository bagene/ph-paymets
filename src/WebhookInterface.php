<?php

namespace Bagene\PhPayments;

use Illuminate\Http\Response;

interface WebhookInterface
{
    /**
     * Handle the incoming webhook.
     *
     * @param array<string, mixed> $payload
     * @return Response|null
     */
    public function handle(array $payload): ?Response;
}
