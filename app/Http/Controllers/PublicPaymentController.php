<?php

namespace App\Http\Controllers;

use App\Jobs\SendPaymentConfirmationJob;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\SchoolClass;
use App\Models\Term;
use App\Models\AcademicSession;
use App\Services\PaystackService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicPaymentController extends Controller
{
    public function create()
    {
        $fees     = Fee::where('is_active', true)->orderBy('name')->get();
        $classes  = SchoolClass::where('is_active', true)->orderBy('name')->get();
        $purposes = \App\Models\PaymentPurpose::where('is_active', true)->orderBy('name')->get();
        $terms    = Term::orderByDesc('starts_at')->get();

        // If a parent is authenticated, load their linked children for smart-fill.
        $authParent     = null;
        $parentStudents = collect();

        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'parent') {
            $authParent     = \Illuminate\Support\Facades\Auth::user();
            $parentStudents = \App\Models\Student::where(function ($q) use ($authParent) {
                    $q->where('parent_user_id', $authParent->id)
                      ->orWhere('parent_email', $authParent->email);
                })
                ->where('status', 'active')
                ->with('schoolClass')
                ->get();
        }

        return view('public.pay', compact('fees', 'classes', 'purposes', 'terms', 'authParent', 'parentStudents'));
    }

    public function studentsByClass(Request $request)
    {
        $request->validate(['class_id' => 'required']);
        
        $students = \App\Models\Student::where('school_class_id', $request->class_id)
            ->where('status', 'active')
            ->orderBy('first_name')
            ->select('id', 'first_name', 'last_name', 'admission_number')
            ->get()
            ->map(function($student) {
                return [
                    'id' => $student->id,
                    'name' => trim("{$student->first_name} {$student->last_name}"),
                    'admission_number' => $student->admission_number
                ];
            });

        return response()->json([
            'success' => true,
            'students' => $students
        ]);
    }

    public function feeLookup(Request $request)
    {
        $request->validate([
            'class_id' => 'required', // We use class_name in the form, need to align this
            'term_id' => 'required',
            'purpose' => 'required|string'
        ]);

        // Attempt to find the specific fee
        $fee = Fee::where('is_active', true)
                  ->whereHas('schoolClass', function($q) use ($request) {
                      // Form sends 'class_name', so let's match by name if we have to, or use ID.
                      $q->where('name', $request->class_id)
                        ->orWhere('id', $request->class_id);
                  })
                  ->where('term_id', $request->term_id)
                  ->where('category', $request->purpose) // category = PaymentPurpose name
                  ->first();

        // If not found, maybe it's not term-specific (term_id = null)
        if (!$fee) {
            $fee = Fee::where('is_active', true)
                ->whereHas('schoolClass', function($q) use ($request) {
                    $q->where('name', $request->class_id)
                    ->orWhere('id', $request->class_id);
                })
                ->whereNull('term_id')
                ->where('category', $request->purpose)
                ->first();
        }

        // If still not found, maybe it's for all classes
        if (!$fee) {
            $fee = Fee::where('is_active', true)
                ->whereNull('school_class_id')
                ->where('category', $request->purpose)
                ->first();
        }

        if ($fee) {
            $fee->load('feeItems');
            return response()->json([
                'success' => true,
                'fee_id' => $fee->id,
                'amount' => $fee->amount,
                'is_variable' => $fee->is_variable,
                'items' => $fee->feeItems->map(function($item) {
                    return [
                        'name' => $item->name,
                        'amount' => $item->amount
                    ];
                })
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No active fee configuration found for this selection.'
        ], 404);
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
            'amount' => ['nullable', 'numeric', 'min:1'],
        ]);

        $fee = Fee::findOrFail($data['fee_id']);
        $amount = $fee->is_variable ? (float) $data['amount'] : (float) $fee->amount;

        $student = \App\Models\Student::where('admission_number', $data['admission_number'])->first();
        
        $payment = Payment::create([
            'fee_id' => $fee->id,
            'academic_session_id' => $fee->academic_session_id,
            'term_id' => $fee->term_id,
            'student_id' => $student ? $student->id : null,
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
            'payment_purpose' => $fee->name,
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
        $filename = 'receipt-'.$payment->payment_reference.'.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
            'Pragma' => 'public'
        ]);
    }
}
