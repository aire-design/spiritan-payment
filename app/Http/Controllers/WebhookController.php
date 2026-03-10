<?php

namespace App\Http\Controllers;

use App\Jobs\SendPaymentConfirmationJob;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function paystack(Request $request, PaystackService $paystack)
    {
        $secret = config('services.paystack.webhook_secret');
        $signature = (string) $request->header('x-paystack-signature');
        $computed = hash_hmac('sha512', $request->getContent(), (string) $secret);

        if (empty($secret) || ! hash_equals($computed, $signature)) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $payload = $request->all();
        $reference = data_get($payload, 'data.reference');
        $event = data_get($payload, 'event', 'unknown');
        $status = data_get($payload, 'data.status', 'pending');
        $verified = $reference ? $paystack->verifyTransaction((string) $reference) : [];
        $verifiedStatus = data_get($verified, 'data.status', $status);

        $payment = Payment::where('gateway_reference', $reference)
            ->orWhere('payment_reference', $reference)
            ->first();

        if ($payment) {
            if ($event === 'charge.success' && $verifiedStatus === 'success') {
                $payment->update([
                    'status' => 'success',
                    'paid_at' => $payment->paid_at ?? now(),
                    'verified_at' => now(),
                    'receipt_number' => $payment->receipt_number ?? ('RCT-'.now()->format('YmdHis').'-'.$payment->id),
                    'channel' => data_get($payload, 'data.channel', $payment->channel),
                    'gateway_payload' => data_get($verified, 'data', $payload),
                ]);

                if ($payment->student) {
                    $payment->student()->update([
                        'outstanding_balance' => $payment->balance_after,
                    ]);
                }

                SendPaymentConfirmationJob::dispatch($payment->id);
            }

            if ($event === 'charge.failed') {
                $payment->update([
                    'status' => 'failed',
                    'gateway_payload' => data_get($verified, 'data', $payload),
                ]);
            }
        }

        PaymentLog::create([
            'payment_id' => $payment?->id,
            'event' => $event,
            'reference' => $reference,
            'status' => $verifiedStatus,
            'payload' => $payload,
        ]);

        Log::info('Paystack webhook processed', ['event' => $event, 'reference' => $reference]);

        return response()->json(['message' => 'Webhook processed']);
    }
}
