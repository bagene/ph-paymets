<?php

namespace Bagene\PhPayments;

interface WebhookInterface
{
    public function updateStatus(array $payload): void;
}
