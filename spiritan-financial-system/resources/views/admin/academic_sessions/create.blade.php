@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="h3 text-spiritan mb-0">Add Academic Session</h2>
    </div>
    <div class="col-auto">
        <a href="{{ route('academic-sessions.index') }}" class="btn btn-light border shadow-sm rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="card md-card border-0">
    <div class="card-body p-4">
        <form action="{{ route('academic-sessions.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                <div class="col-md-12">
                    <label for="name" class="form-label fw-bold text-secondary">Session Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control elegant-input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. 2024/2025" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="starts_at" class="form-label fw-bold text-secondary">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control elegant-input @error('starts_at') is-invalid @enderror" id="starts_at" name="starts_at" value="{{ old('starts_at') }}" required>
                    @error('starts_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="ends_at" class="form-label fw-bold text-secondary">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control elegant-input @error('ends_at') is-invalid @enderror" id="ends_at" name="ends_at" value="{{ old('ends_at') }}" required>
                    @error('ends_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_locked" name="is_locked" value="1" {{ old('is_locked') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-secondary ms-2" for="is_locked">Mark as Locked (Disabled)</label>
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted">

            <div class="d-flex justify-content-end gap-3">
                <button type="submit" class="btn btn-md-primary rounded-pill px-5 shadow fw-bold transition-all py-2" style="letter-spacing: 0.02em;">
                    Save Academic Session
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .elegant-input {
        border-radius: 8px;
        border: 1px solid #ced4da;
        background-color: #f8f9fa;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }
    .elegant-input:focus {
        border-color: var(--md-primary);
        box-shadow: 0 0 0 4px var(--md-primary-container);
        background-color: #ffffff;
    }
</style>
@endsection
