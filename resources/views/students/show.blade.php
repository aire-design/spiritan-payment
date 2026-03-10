@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Student Details</h3>
        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card p-4 mb-3">
        <div class="row g-3">
            <div class="col-md-6"><strong>Name:</strong> {{ $student->full_name }}</div>
            <div class="col-md-6"><strong>Admission No:</strong> {{ $student->admission_number }}</div>
            <div class="col-md-6"><strong>Class:</strong> {{ $student->schoolClass?->name }}</div>
            <div class="col-md-6"><strong>Parent:</strong> {{ $student->parent_name }} ({{ $student->parent_phone }})</div>
            <div class="col-md-6"><strong>Outstanding Balance:</strong> ₦{{ number_format($student->outstanding_balance, 2) }}</div>
        </div>
    </div>

    <div class="card p-3">
        <h5 class="mb-3">Payment History</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>Reference</th>
                <th>Fee</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse($student->payments as $payment)
                <tr>
                    <td>{{ $payment->payment_reference }}</td>
                    <td>{{ $payment->fee?->name }}</td>
                    <td>₦{{ number_format($payment->amount_paid, 2) }}</td>
                    <td>{{ strtoupper($payment->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No payments yet.</td></tr>
            @endforelse
            </tbody>
            </table>
        </div>
    </div>
@endsection
