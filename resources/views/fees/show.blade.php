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
        
        @if($fee->feeItems->isNotEmpty())
            <hr class="my-4">
            <h5 class="fw-bold mb-3">Fee Breakdown (Items)</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Item Name</th>
                            <th class="text-end">Amount (₦)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fee->feeItems as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="text-end">{{ number_format($item->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-end">Total Computed Amount:</th>
                            <th class="text-end">₦{{ number_format($fee->amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
@endsection
