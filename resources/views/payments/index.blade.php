@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Payments</h3>
        <a class="btn btn-spiritan" href="{{ route('payments.create') }}">Record / Initialize Payment</a>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>Reference</th>
                <th>Student</th>
                <th>Fee</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->payment_reference }}</td>
                    <td>{{ $payment->student?->full_name }}</td>
                    <td>{{ $payment->fee?->name }}</td>
                    <td>₦{{ number_format($payment->amount_paid, 2) }}</td>
                    <td>{{ strtoupper($payment->payment_method) }}</td>
                    <td><span class="badge bg-{{ $payment->status === 'success' ? 'success' : ($payment->status === 'pending' ? 'warning text-dark' : 'danger') }}">{{ strtoupper($payment->status) }}</span></td>
                    <td><a class="btn btn-outline-primary btn-sm" href="{{ route('payments.show', $payment) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="7">No payments found.</td></tr>
            @endforelse
            </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $payments->links() }}</div>
    </div>
@endsection
