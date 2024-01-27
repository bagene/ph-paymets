<?php

namespace Bagene\PhPayments;

interface WebhookInterface
{
    public function updateStatus($payload): void;
}
