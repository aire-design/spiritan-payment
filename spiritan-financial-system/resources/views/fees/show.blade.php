@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Fee Details</h3>
        <a href="{{ route('fees.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card p-4">
        <div class="row g-3">
            <div class="col-md-6"><strong>Name:</strong> {{ $fee->name }}</div>
            <div class="col-md-6"><strong>Category:</strong> {{ $fee->category }}</div>
            <div class="col-md-6"><strong>Amount:</strong> ₦{{ number_format($fee->amount, 2) }}</div>
            <div class="col-md-6"><strong>Class:</strong> {{ $fee->schoolClass?->name ?? 'All' }}</div>
            <div class="col-md-6"><strong>Session:</strong> {{ $fee->academicSession?->name }}</div>
            <div class="col-md-6"><strong>Term:</strong> {{ $fee->term?->name ?? 'N/A' }}</div>
        </div>
    </div>
@endsection
