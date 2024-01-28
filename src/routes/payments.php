<?php

use Bagene\PhPayments\Controllers\XenditWebhookController;
use Illuminate\Support\Facades\Route;

Route::post(
    '/webhooks/{provider}/invoice',
    [XenditWebhookController::class, 'parse']
)->name('xendit.invoice.create');
