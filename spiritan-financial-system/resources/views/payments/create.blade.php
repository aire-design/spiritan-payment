








































@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Record / Initialize Payment</h3>
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card p-4">
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Student</label>
                    <select class="form-select" name="student_id" required>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->admission_number }} - {{ $student->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fee</label>
                    <select class="form-select" name="fee_id" required>
                        @foreach($fees as $fee)
                            <option value="{{ $fee->id }}">{{ $fee->name }} (₦{{ number_format($fee->amount, 2) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Amount Paid</label>
                    <input class="form-control" name="amount_paid" type="number" step="0.01" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Payment Method</label>
                    <select class="form-select" name="payment_method" required>
                        <option value="paystack">Paystack</option>
                        <option value="cash">Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="pos">POS</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Payer Email</label>
                    <input class="form-control" name="payer_email" type="email">
                </div>
            </div>
            <button class="btn btn-spiritan mt-4" type="submit">Save Payment</button>
        </form>
    </div>
@endsection
