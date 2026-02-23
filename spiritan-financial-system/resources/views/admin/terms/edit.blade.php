@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Edit Term</h3>
        <a href="{{ route('terms.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card p-4">
        @if ($errors->any())
            <div class="alert alert-danger pb-0">
                <ul class="mb-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('terms.update', $term) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Academic Session</label>
                    <select class="form-select" name="academic_session_id" required>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}" {{ $term->academic_session_id === $session->id ? 'selected' : '' }}>
                                {{ $session->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Term Name</label>
                    <input class="form-control" name="name" type="text" value="{{ old('name', $term->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Start Date</label>
                    <input class="form-control" name="starts_at" type="date" value="{{ old('starts_at', $term->starts_at?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Date</label>
                    <input class="form-control" name="ends_at" type="date" value="{{ old('ends_at', $term->ends_at?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-12">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="is_locked" id="is_locked" value="1" {{ $term->is_locked ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_locked">
                            Lock Term (Prevents new additions unless specifically unlocked)
                        </label>
                    </div>
                </div>
            </div>
            <button class="btn btn-spiritan mt-4" type="submit">Update Term</button>
        </form>
    </div>
@endsection
