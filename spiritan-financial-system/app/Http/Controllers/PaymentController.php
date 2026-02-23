<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['student', 'fee'])->latest()->paginate(20);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')->orderBy('last_name')->get();
        $fees = Fee::where('is_active', true)->orderBy('name')->get();
        return view('payments.create', compact('students', 'fees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'fee_id' => ['required', 'exists:fees,id'],
            'amount_paid' => ['required', 'numeric', 'min:1'],
            'payment_method' => ['required', 'in:paystack,cash,bank_transfer,pos'],
            'payer_email' => ['nullable', 'email'],
        ]);

        $student = Student::findOrFail($data['student_id']);
        $fee = Fee::findOrFail($data['fee_id']);

        $balanceAfter = max(0, (float) $student->outstanding_balance - (float) $data['amount_paid']);
        $isOffline = in_array($data['payment_method'], ['cash', 'bank_transfer', 'pos'], true);

        $payment = Payment::create([
            'student_id' => $student->id,
            'student_full_name' => $student->full_name,
            'admission_number' => $student->admission_number,
            'class_name' => $student->schoolClass?->name,
            'fee_id' => $fee->id,
            'academic_session_id' => $fee->academic_session_id,
            'term_id' => $fee->term_id,
            'recorded_by' => null,
            'amount_paid' => $data['amount_paid'],
            'discount_amount' => 0,
            'late_fee_applied' => 0,
            'balance_after' => $balanceAfter,
            'payment_reference' => 'SPT-' . strtoupper(Str::random(10)),
            'gateway_reference' => $isOffline ? null : 'PSK-' . strtoupper(Str::random(12)),
            'payment_method' => $data['payment_method'],
            'payment_type' => $fee->category,
            'payment_purpose' => $fee->name,
            'channel' => $data['payment_method'],
            'status' => $isOffline ? 'success' : 'pending',
            'paid_at' => $isOffline ? now() : null,
            'verified_at' => $isOffline ? now() : null,
            'receipt_number' => $isOffline ? ('RCT-' . now()->format('YmdHis') . '-' . $student->id) : null,
            'payer_email' => $data['payer_email'] ?? $student->parent_email,
            'parent_phone' => $student->parent_phone,
            'metadata' => [
                'student' => $student->full_name,
                'fee' => $fee->name,
            ],
        ]);

        if ($isOffline) {
            $student->update(['outstanding_balance' => $balanceAfter]);
        }

        PaymentLog::create([
            'payment_id' => $payment->id,
            'event' => 'payment.created',
            'reference' => $payment->payment_reference,
            'status' => $payment->status,
            'payload' => $payment->toArray(),
        ]);

        return redirect()->route('payments.show', $payment)->with('success', 'Payment initialized successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['student', 'fee', 'academicSession', 'term', 'logs']);
        return view('payments.show', compact('payment'));
    }
}
