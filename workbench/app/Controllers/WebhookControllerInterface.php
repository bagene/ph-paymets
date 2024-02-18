<?php

namespace Workbench\App\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface WebhookControllerInterface
{
    /** @throws Exception */
    public function parse(Request $request): ?Response;
}
