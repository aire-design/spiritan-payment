@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <a href="{{ route('purposes.index') }}" class="text-decoration-none text-secondary d-flex align-items-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
            Back to Purposes
        </a>
        <h2 class="h3 text-spiritan">Edit Purpose: {{ $purpose->name }}</h2>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card md-card border-0 p-4">
            <form action="{{ route('purposes.update', $purpose) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label text-secondary fw-medium">Purpose Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control elegant-input @error('name') is-invalid @enderror" value="{{ old('name', $purpose->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-secondary fw-medium">Description</label>
                    <textarea name="description" class="form-control elegant-input @error('description') is-invalid @enderror" rows="3">{{ old('description', $purpose->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-4 form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="isActiveSwitch" name="is_active" value="1" {{ old('is_active', $purpose->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label text-secondary" for="isActiveSwitch">Active / Selectable via Forms</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-spiritan py-2">Update Purpose</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .elegant-input { border-radius: 8px; border: 1px solid #e1e2ec; background-color: #fdfbff; }
    .elegant-input:focus { border-color: var(--md-primary); box-shadow: 0 0 0 3px var(--md-primary-container); background-color: #ffffff; }
</style>
@endsection
