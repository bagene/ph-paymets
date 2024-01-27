<?php

use Bagene\PhPayments\Controllers\XenditWebhookController;
use Illuminate\Support\Facades\Route;

Route::post(
    '/xendit/invoice',
    [XenditWebhookController::class, 'parse']
)->name('xendit.invoice.create');
