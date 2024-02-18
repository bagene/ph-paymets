<?php

namespace Bagene\PhPayments\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface WebhookControllerInterface
{
    public function parse(Request $request): ?Response;
}
