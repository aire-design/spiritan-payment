@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h3 class="text-spiritan">Payment Receipt</h3>
                <hr>
                <p><strong>School:</strong> Spiritan International Girls' School</p>
                <p><strong>Student Name:</strong> {{ $payment->student_full_name }}</p>
                <p><strong>Admission Number:</strong> {{ $payment->admission_number }}</p>
                <p><strong>Class:</strong> {{ $payment->class_name }}</p>
                <p><strong>Amount Paid:</strong> ₦{{ number_format($payment->amount_paid, 2) }}</p>
                <p><strong>Payment Purpose:</strong> {{ $payment->payment_purpose }}</p>
                <p><strong>Transaction Reference:</strong> {{ $payment->payment_reference }}</p>
                <p><strong>Status:</strong> {{ strtoupper($payment->status) }}</p>
                <p><strong>Date:</strong> {{ optional($payment->paid_at)->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A') }}</p>

                <a href="{{ route('pay.receipt.pdf', $payment) }}" class="btn btn-outline-primary mt-2">Download PDF Receipt</a>
            </div>
        </div>
    </div>
@endsection
