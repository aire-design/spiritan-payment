@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Add Fee</h3>
        <a href="{{ route('fees.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card p-4">
        <form method="POST" action="{{ route('fees.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
                <div class="col-md-6"><label class="form-label">Category</label><input class="form-control" name="category" required></div>
                <div class="col-md-6"><label class="form-label">Amount</label><input class="form-control" type="number" step="0.01" name="amount" required></div>
                <div class="col-md-6">
                    <label class="form-label">Class</label>
                    <select class="form-select" name="school_class_id">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Session</label>
                    <select class="form-select" name="academic_session_id" required>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Term</label>
                    <select class="form-select" name="term_id">
                        <option value="">Not Term-specific</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}">{{ $term->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6"><label class="form-label">Due Date</label><input class="form-control" type="date" name="due_date"></div>
                <div class="col-md-6"><label class="form-label">Late Fee Penalty</label><input class="form-control" type="number" step="0.01" name="late_fee_penalty" value="0"></div>
            </div>
            <button class="btn btn-spiritan mt-4" type="submit">Save Fee</button>
        </form>
    </div>
@endsection
