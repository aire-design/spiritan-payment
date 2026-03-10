@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-spiritan mb-0">Financial Reports & Parent Payments</h2>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card md-card border-0 p-4 h-100">
                <h6 class="text-secondary fw-medium mb-3">Total Collected</h6>
                <h3 class="mb-0 text-success">₦{{ number_format($summary['total_paid'], 2) }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card md-card border-0 p-4 h-100">
                <h6 class="text-secondary fw-medium mb-3">Pending Transactions</h6>
                <h3 class="mb-0 text-warning">{{ $summary['pending_transactions'] }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card md-card border-0 p-4 h-100">
                <h6 class="text-secondary fw-medium mb-3">Failed Transactions</h6>
                <h3 class="mb-0 text-danger">{{ $summary['failed_transactions'] }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card md-card border-0 p-4 h-100">
                <h6 class="text-secondary fw-medium mb-3">Recorded Outstanding</h6>
                <h3 class="mb-0 text-spiritan">₦{{ number_format($summary['outstanding_total'], 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="card md-card border-0 p-4 mb-4">
        <h5 class="mb-3 text-secondary" style="font-size: 1rem;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16"><path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/></svg>Advanced Filters</h5>
        <form method="GET" action="{{ route('reports.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4 col-lg-2">
                    <label class="form-label text-muted small">Date From</label>
                    <input type="date" class="form-control elegant-input" name="from_date" value="{{ $fromDate }}">
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label text-muted small">Date To</label>
                    <input type="date" class="form-control elegant-input" name="to_date" value="{{ $toDate }}">
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label text-muted small">Status</label>
                    <select class="form-select elegant-input" name="status">
                        <option value="">All Statuses</option>
                        <option value="success" @selected($status === 'success')>Success</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="failed" @selected($status === 'failed')>Failed</option>
                    </select>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label text-muted small">Class/Grade</label>
                    <select class="form-select elegant-input" name="class_name">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class }}" @selected($className === $class)>{{ $class }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label text-muted small">Payment Purpose</label>
                    <select class="form-select elegant-input" name="payment_purpose_id">
                        <option value="">All Purposes</option>
                        @foreach($purposes as $purpose)
                            <option value="{{ $purpose->id }}" @selected(request('payment_purpose_id') == $purpose->id)>{{ $purpose->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-lg-2">
                    <label class="form-label text-muted small">Admission No.</label>
                    <input class="form-control elegant-input" name="admission_number" value="{{ $admissionNumber }}">
                </div>
                
                <div class="col-12 mt-4 d-flex flex-wrap gap-2 justify-content-end">
                    <button class="btn btn-spiritan px-4 shadow-sm" type="submit">Apply Filters</button>
                    <a href="{{ route('reports.export.csv', request()->query()) }}" class="btn btn-outline-success px-3">CSV</a>
                    <a href="{{ route('reports.export.excel', request()->query()) }}" class="btn btn-outline-primary px-3">Excel</a>
                    <a href="{{ route('reports.export.pdf', request()->query()) }}" class="btn btn-outline-danger px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf me-1" viewBox="0 0 16 16"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/><path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/></svg> 
                        Print PDF
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Table -->
    <div class="card md-card border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Parent Details</th>
                            <th>Student / Class</th>
                            <th>Payment Purpose</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td class="ps-4 text-muted small">{{ optional($payment->created_at)->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="fw-medium">{{ $payment->parent_email }}</div>
                                <div class="small text-secondary">{{ $payment->parent_phone }}</div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $payment->student?->full_name ?? $payment->student_full_name }}</div>
                                <div class="small text-secondary">{{ $payment->class_name }} • {{ $payment->admission_number }}</div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ current(explode('-', $payment->fee?->name ?? $payment->payment_type)) }}</div>
                                <div class="small text-secondary text-truncate" style="max-width:200px;">{{ $payment->payment_purpose ?: 'Standard' }}</div>
                            </td>
                            <td class="fw-bold text-spiritan">₦{{ number_format($payment->amount_paid, 2) }}</td>
                            <td>
                                @if($payment->status === 'success')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>Paid</span>
                                @elseif($payment->status === 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-clock-fill me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/></svg>Pending</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-x-circle-fill me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/></svg>Failed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-clipboard-x mb-3" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708z"/><path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/><path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/></svg>
                                <p class="mb-0">No payment records found.</p>
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

<style>
    .elegant-input { border-radius: 8px; border: 1px solid #e1e2ec; background-color: #fdfbff; }
    .elegant-input:focus { border-color: var(--md-primary); box-shadow: 0 0 0 3px var(--md-primary-container); background-color: #ffffff; }
</style>
@endsection
