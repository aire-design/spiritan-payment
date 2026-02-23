@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4">
                <h3 class="text-spiritan mb-3">Make School Payment</h3>
                <p class="text-muted">Secure payment powered by Paystack</p>

                <form method="POST" action="{{ route('pay.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Student Full Name</label>
                            <input class="form-control" name="student_full_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Admission Number</label>
                            <input class="form-control" name="admission_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Class / Grade</label>
                            <select class="form-select" name="class_name" required>
                                @foreach($classes as $class)
                                    <option value="{{ $class->name }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Parent Email</label>
                            <input type="email" class="form-control" name="parent_email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Parent Phone Number</label>
                            <input class="form-control" name="parent_phone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Purpose</label>
                            <select class="form-select" name="fee_id" required>
                                @foreach($fees as $fee)
                                    <option value="{{ $fee->id }}">{{ $fee->name }} @if(!$fee->is_variable)- ₦{{ number_format($fee->amount, 2) }}@endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amount (for variable fee only)</label>
                            <input type="number" step="0.01" class="form-control" name="amount">
                        </div>
                    </div>

                    <button class="btn btn-spiritan mt-4">Proceed to Paystack</button>
                </form>
            </div>
        </div>
    </div>
@endsection
