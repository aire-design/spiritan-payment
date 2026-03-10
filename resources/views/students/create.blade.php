@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Add Student</h3>
        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card p-4">
        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Admission Number</label>
                    <input class="form-control" name="admission_number" value="{{ old('admission_number') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Other Name</label>
                    <input class="form-control" name="other_name" value="{{ old('other_name') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Class</label>
                    <select class="form-select" name="school_class_id" required>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Session</label>
                    <select class="form-select" name="academic_session_id">
                        <option value="">-- Select --</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Parent Name</label>
                    <input class="form-control" name="parent_name" value="{{ old('parent_name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Parent Phone</label>
                    <input class="form-control" name="parent_phone" value="{{ old('parent_phone') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Parent Email</label>
                    <input class="form-control" name="parent_email" type="email" value="{{ old('parent_email') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="graduated">Graduated</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-spiritan mt-4" type="submit">Save Student</button>
        </form>
    </div>
@endsection
