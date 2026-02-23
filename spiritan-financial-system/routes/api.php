<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/paystack/webhook', [WebhookController::class, 'paystack'])
    ->name('api.paystack.webhook');
