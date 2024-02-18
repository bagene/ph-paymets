<?php

namespace Bagene\PhPayments;

use Exception;
use Illuminate\Http\Response;

interface WebhookInterface
{
    /**
     * Handle the incoming webhook.
     *
     * @param array<string, mixed> $payload
     * @throws Exception
     * @return Response|null
     */
    public function handle(array $payload): mixed;
}
