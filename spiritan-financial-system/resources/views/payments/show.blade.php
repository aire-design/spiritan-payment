@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Payment Details</h3>
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card p-4 mb-3">
        <div class="row g-3">
            <div class="col-md-6"><strong>Reference:</strong> {{ $payment->payment_reference }}</div>
            <div class="col-md-6"><strong>Student:</strong> {{ $payment->student?->full_name }}</div>
            <div class="col-md-6"><strong>Fee:</strong> {{ $payment->fee?->name }}</div>
            <div class="col-md-6"><strong>Amount:</strong> ₦{{ number_format($payment->amount_paid, 2) }}</div>
            <div class="col-md-6"><strong>Status:</strong> <span class="badge bg-{{ $payment->status === 'success' ? 'success' : ($payment->status === 'pending' ? 'warning text-dark' : 'danger') }}">{{ strtoupper($payment->status) }}</span></div>
            <div class="col-md-6"><strong>Method:</strong> {{ strtoupper($payment->payment_method) }}</div>
            <div class="col-md-6"><strong>Receipt:</strong> {{ $payment->receipt_number ?? 'Pending' }}</div>
        </div>
    </div>

    <div class="card p-3">
        <h5 class="mb-3">Payment Logs</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>Event</th>
                <th>Reference</th>
                <th>Status</th>
                <th>Time</th>
            </tr>
            </thead>
            <tbody>
            @forelse($payment->logs as $log)
                <tr>
                    <td>{{ $log->event }}</td>
                    <td>{{ $log->reference }}</td>
                    <td>{{ strtoupper($log->status ?? 'n/a') }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No logs yet.</td></tr>
            @endforelse
            </tbody>
            </table>
        </div>
    </div>
@endsection
