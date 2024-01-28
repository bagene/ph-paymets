<?php

namespace Bagene\PhPayments\Controllers;

use Illuminate\Http\Request;

interface WebhookControllerInterface
{
    public function parse(Request $request);
}
