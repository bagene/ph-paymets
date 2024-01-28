<?php

namespace Bagene\PhPayments;

use Illuminate\Http\Response;

interface WebhookInterface
{
    public function handle(array $payload): ?Response;
}
