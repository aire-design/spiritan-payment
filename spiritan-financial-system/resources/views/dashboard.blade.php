@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1 text-spiritan">Financial Dashboard</h3>
            <p class="text-muted mb-0">Overview of students and collections</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted mb-2">Total Students</h6>
                <h3 class="mb-0">{{ $totalStudents }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted mb-2">Active Students</h6>
                <h3 class="mb-0">{{ $activeStudents }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted mb-2">Total Successful Payments</h6>
                <h3 class="mb-0">₦{{ number_format($totalPaid, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="card p-3">
        <h5 class="mb-3">Recent Payments</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Reference</th>
                        <th>Student</th>
                        <th>Fee</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
            @forelse($recentPayments as $payment)
                <tr>
                    <td>{{ $payment->payment_reference }}</td>
                    <td>{{ $payment->student?->full_name }}</td>
                    <td>{{ $payment->fee?->name }}</td>
                    <td>₦{{ number_format($payment->amount_paid, 2) }}</td>
                    <td><span class="badge bg-{{ $payment->status === 'success' ? 'success' : ($payment->status === 'pending' ? 'warning text-dark' : 'danger') }}">{{ strtoupper($payment->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5">No recent payments found.</td></tr>
            @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
