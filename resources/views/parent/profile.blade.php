@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center text-md-start">
            <h1 class="display-6 fw-bold" style="font-family: 'Outfit'; color: var(--md-on-surface);">My Profile</h1>
            <p class="text-secondary lead">Update your portal access and contact details</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3 shadow-sm border-0 bg-success text-white">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger mt-3 shadow-sm border-0">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8 animate__animated animate__fadeInUp">
            <div class="card md-card border-0 p-4 p-md-5">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    
                    <h5 class="fw-bold mb-4" style="font-family: 'Outfit'; color: var(--md-primary);">Personal Information</h5>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">First Name</label>
                            <input type="text" class="form-control elegant-input" id="firstName" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="lastName" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Last Name</label>
                            <input type="text" class="form-control elegant-input" id="lastName" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Email Address</label>
                            <input type="email" class="form-control elegant-input" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Phone Number</label>
                            <input type="text" class="form-control elegant-input" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required>
                        </div>
                        
                        <div class="col-md-12 mt-5">
                            <h5 class="fw-bold mb-4" style="font-family: 'Outfit'; color: var(--md-primary);">Security (Optional)</h5>
                            <p class="text-secondary small mb-3">Leave password fields blank if you do not wish to change your password.</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">New Password</label>
                            <input type="password" class="form-control elegant-input" id="password" name="password" placeholder="Min 6 characters">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Confirm New Password</label>
                            <input type="password" class="form-control elegant-input" id="password_confirmation" name="password_confirmation" placeholder="Repeat new password">
                        </div>
                    </div>
                    
                    <hr class="my-5 text-muted">
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-end gap-3 mt-4">
                        <a href="{{ route('parent.history') }}" class="btn btn-light btn-lg px-4 rounded-pill fw-medium border shadow-sm transition-all text-secondary d-flex align-items-center justify-content-center">Cancel</a>
                        <button type="submit" class="btn btn-md-primary btn-lg px-5 shadow rounded-pill fw-bold transition-all py-3" style="letter-spacing: 0.02em;">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
    .form-label {
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
    }
</style>
@endsection
