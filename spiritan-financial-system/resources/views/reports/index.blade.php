@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Financial Reports</h3>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="card p-3"><h6 class="text-muted">Total Paid</h6><h4>₦{{ number_format($summary['total_paid'], 2) }}</h4></div></div>
        <div class="col-md-3"><div class="card p-3"><h6 class="text-muted">Pending Transactions</h6><h4>{{ $summary['pending_transactions'] }}</h4></div></div>
        <div class="col-md-3"><div class="card p-3"><h6 class="text-muted">Failed Transactions</h6><h4>{{ $summary['failed_transactions'] }}</h4></div></div>
        <div class="col-md-3"><div class="card p-3"><h6 class="text-muted">Outstanding Balance</h6><h4>₦{{ number_format($summary['outstanding_total'], 2) }}</h4></div></div>
    </div>

    <div class="card p-3 mb-3">
        <form method="GET" action="{{ route('reports.index') }}">
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" name="from_date" value="{{ $fromDate }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" name="to_date" value="{{ $toDate }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filter by Status</label>
                    <select class="form-select" name="status">
                        <option value="">All</option>
                        <option value="success" @selected($status === 'success')>Success</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="failed" @selected($status === 'failed')>Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Payment Type</label>
                    <select class="form-select" name="payment_type">
                        <option value="">All</option>
                        @foreach($paymentTypes as $type)
                            <option value="{{ $type }}" @selected($paymentType === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Class</label>
                    <select class="form-select" name="class_name">
                        <option value="">All</option>
                        @foreach($classes as $class)
                            <option value="{{ $class }}" @selected($className === $class)>{{ $class }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Admission Number</label>
                    <input class="form-control" name="admission_number" value="{{ $admissionNumber }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-spiritan w-100" type="submit">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('reports.export.csv', request()->query()) }}" class="btn btn-outline-success w-100">Export CSV</a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('reports.export.excel', request()->query()) }}" class="btn btn-outline-primary w-100">Export Excel</a>
                </div>
            </div>
        </form>
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
                <th>Status</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->payment_reference }}</td>
                    <td>{{ $payment->student?->full_name ?? $payment->student_full_name }}</td>
                    <td>{{ $payment->fee?->name }}</td>
                    <td>₦{{ number_format($payment->amount_paid, 2) }}</td>
                    <td>{{ strtoupper($payment->status) }}</td>
                    <td>{{ $payment->created_at }}</td>
                </tr>
            @empty
                <tr><td colspan="6">No report data found.</td></tr>
            @endforelse
            </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $payments->links() }}</div>
    </div>
@endsection
