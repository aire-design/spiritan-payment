<?php

namespace App\Http\Controllers;

use App\Jobs\SendPaymentConfirmationJob;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\SchoolClass;
use App\Services\PaystackService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicPaymentController extends Controller
{
    public function create()
    {
        $fees = Fee::where('is_active', true)->orderBy('name')->get();
        $classes = SchoolClass::where('is_active', true)->orderBy('name')->get();
        $purposes = \App\Models\PaymentPurpose::where('is_active', true)->orderBy('name')->get();

        return view('public.pay', compact('fees', 'classes', 'purposes'));
    }

    public function store(Request $request, PaystackService $paystack)
    {
        $data = $request->validate([
            'student_full_name' => ['required', 'string', 'max:150'],
            'admission_number' => ['required', 'string', 'max:50'],
            'class_name' => ['required', 'string', 'max:80'],
            'parent_email' => ['required', 'email'],
            'parent_phone' => ['required', 'string', 'max:25'],
            'fee_id' => ['required', 'exists:fees,id'],
            'payment_purpose' => ['required', 'string', 'max:150'],
            'amount' => ['nullable', 'numeric', 'min:1'],
        ]);

        $fee = Fee::findOrFail($data['fee_id']);
        $amount = $fee->is_variable ? (float) $data['amount'] : (float) $fee->amount;

        $payment = Payment::create([
            'fee_id' => $fee->id,
            'academic_session_id' => $fee->academic_session_id,
            'term_id' => $fee->term_id,
            'student_id' => null,
            'student_full_name' => $data['student_full_name'],
            'admission_number' => $data['admission_number'],
            'class_name' => $data['class_name'],
            'amount_paid' => $amount,
            'discount_amount' => 0,
            'late_fee_applied' => 0,
            'balance_after' => 0,
            'payment_reference' => 'SPT-'.strtoupper(Str::random(10)),
            'payment_method' => 'paystack',
            'payment_type' => $fee->category,
            'payment_purpose' => $data['payment_purpose'],
            'channel' => 'web',
            'status' => 'pending',
            'payer_email' => $data['parent_email'],
            'parent_phone' => $data['parent_phone'],
            'metadata' => [
                'source' => 'public_payment_form',
            ],
        ]);

        $response = $paystack->initializeTransaction($payment, $amount, route('pay.verify', $payment));
        $payment->update(['gateway_reference' => data_get($response, 'data.reference', $payment->payment_reference)]);

        return redirect()->away((string) data_get($response, 'data.authorization_url', route('pay.create')));
    }

    public function verify(Payment $payment, Request $request, PaystackService $paystack)
    {
        $reference = (string) $request->query('reference', $payment->gateway_reference ?? $payment->payment_reference);
        $verified = $paystack->verifyTransaction($reference);
        $status = data_get($verified, 'data.status');

        if ($status === 'success') {
            $payment->update([
                'status' => 'success',
                'paid_at' => now(),
                'verified_at' => now(),
                'channel' => data_get($verified, 'data.channel', 'web'),
                'receipt_number' => $payment->receipt_number ?? ('RCT-'.now()->format('YmdHis').'-'.$payment->id),
                'gateway_payload' => data_get($verified, 'data', []),
            ]);

            SendPaymentConfirmationJob::dispatch($payment->id);
        }

        return redirect()->route('pay.receipt', $payment)
            ->with('success', $status === 'success' ? 'Payment successful.' : 'Payment verification pending.');
    }

    public function receipt(Payment $payment)
    {
        return view('public.receipt', compact('payment'));
    }

    public function receiptPdf(Payment $payment)
    {
        $pdf = Pdf::loadView('receipts.payment', ['payment' => $payment]);

        return $pdf->download('receipt-'.$payment->payment_reference.'.pdf');
    }
}
