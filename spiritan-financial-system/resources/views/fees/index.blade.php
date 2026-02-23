@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Fees</h3>
        <a class="btn btn-spiritan" href="{{ route('fees.create') }}">Add Fee</a>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Class</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($fees as $fee)
                <tr>
                    <td>{{ $fee->name }}</td>
                    <td>{{ $fee->category }}</td>
                    <td>₦{{ number_format($fee->amount, 2) }}</td>
                    <td>{{ $fee->schoolClass?->name ?? 'All' }}</td>
                    <td><a class="btn btn-outline-primary btn-sm" href="{{ route('fees.show', $fee) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="5">No fees found.</td></tr>
            @endforelse
            </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $fees->links() }}</div>
    </div>
@endsection
