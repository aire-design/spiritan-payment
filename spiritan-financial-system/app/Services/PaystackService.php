<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

class PaystackService
{
    public function initializeTransaction(Payment $payment, float $amount, string $callbackUrl): array
    {
        $payload = [
            'email' => $payment->payer_email,
            'amount' => (int) round($amount * 100),
            'reference' => $payment->payment_reference,
            'callback_url' => $callbackUrl,
            'metadata' => [
                'payment_id' => $payment->id,
                'admission_number' => $payment->admission_number,
                'payment_type' => $payment->payment_type,
            ],
        ];

        return $this->request('post', (string) config('services.paystack.payment_url'), $payload);
    }

    public function verifyTransaction(string $reference): array
    {
        $url = rtrim((string) config('services.paystack.verify_url'), '/') . '/' . urlencode($reference);
        return $this->request('get', $url);
    }

    protected function request(string $method, string $url, array $payload = []): array
    {
        $token = (string) config('services.paystack.secret_key');

        $request = Http::withToken($token)
            ->acceptJson()
            ->timeout(20);

        $response = strtolower($method) === 'post'
            ? $request->post($url, $payload)
            : $request->get($url);

        return $response->json() ?? [];
    }
}
