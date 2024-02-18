<?php

namespace Bagene\PhPayments\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface WebhookControllerInterface
{
    /**
     * Handle the incoming webhook.
     *
     * @throws \Exception
     */
    public function parse(Request $request): mixed;
}
