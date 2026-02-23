@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 text-spiritan mb-0">My Payment History</h2>
    <a href="{{ route('pay.create') }}" class="btn btn-spiritan">Make New Payment</a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card md-card border-0 p-4 h-100 shadow-sm">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#198754" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                </div>
                <div>
                    <h6 class="text-secondary fw-medium mb-1">Total Paid</h6>
                    <h3 class="mb-0 text-success">₦{{ number_format($totalPaid, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card md-card border-0 p-4 h-100 shadow-sm">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffc107" class="bi bi-clock-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/></svg>
                </div>
                <div>
                    <h6 class="text-secondary fw-medium mb-1">Pending Transactions</h6>
                    <h3 class="mb-0 text-warning">{{ $totalPending }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card md-card border-0">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 text-spiritan">Transaction Records</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Student / Class</th>
                        <th>Purpose / Ref</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Receipt</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td class="ps-4 text-secondary small">{{ optional($payment->created_at)->format('M d, Y h:i A') }}</td>
                        <td>
                            <div class="fw-medium">{{ $payment->student?->full_name ?? $payment->student_full_name }}</div>
                            <div class="small text-secondary">{{ $payment->class_name }} • {{ $payment->admission_number }}</div>
                        </td>
                        <td>
                            <div class="fw-medium">{{ current(explode('-', $payment->fee?->name ?? $payment->payment_type)) }}</div>
                            <div class="small text-muted">{{ $payment->payment_reference }}</div>
                        </td>
                        <td class="fw-bold text-spiritan">₦{{ number_format($payment->amount_paid, 2) }}</td>
                        <td>
                            @if($payment->status === 'success')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1">Success</span>
                            @elseif($payment->status === 'pending')
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1">Pending</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1">Failed</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if($payment->status === 'success')
                                <a href="{{ route('pay.receipt.pdf', $payment) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-download me-1" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg> 
                                    Receipt
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-wallet2 mb-3 opacity-50" viewBox="0 0 16 16"><path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.5-1.5H2V1.78a1.5 1.5 0 0 1 1.864-1.454L12.136.326zM14 5.5H1.5v8h13v-8zM5 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                            <p class="mb-0">No payment history found for your account.</p>
                            <div class="mt-3">
                                <a href="{{ route('pay.create') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">Make Your First Payment</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
