@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center g-5 min-vh-75">
        
        <!-- Elegant Information Side -->
        <div class="col-lg-4 d-none d-lg-block animate__animated animate__fadeInLeft">
            <div class="pe-4">
                <div class="badge rounded-pill mb-3 px-3 py-2" style="background: var(--md-secondary-container); color: var(--md-on-secondary-container); font-family: 'Outfit'; font-weight: 500;">
                    Parent Access
                </div>
                <h1 class="display-6 fw-bold mb-4" style="font-family: 'Outfit'; color: var(--md-on-surface);">Join the Portal</h1>
                <p class="mb-5 text-secondary" style="font-size: 1.1rem; line-height: 1.6;">
                    Register once and enjoy secure, streamlined digital payment services for all school charges and fees.
                </p>
                
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: #eef2ff; color: var(--md-primary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lightning-charge" viewBox="0 0 16 16"><path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41 4.157 8.5z"/></svg>
                        </div>
                        <span class="text-secondary fw-medium">Faster Payment Checkout</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: #fbf0ff; color: var(--md-tertiary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16"><path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M9.5 3L8 4.5V9l3 3"/></svg>
                        </div>
                        <span class="text-secondary fw-medium">Complete Receipt History</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Elegant Form Side -->
        <div class="col-lg-6 col-md-9 animate__animated animate__fadeInRight">
            <div class="card md-card border-0 p-4 p-md-5">
                <div class="text-center mb-4 d-lg-none">
                    <img src="{{ asset('logo.png') }}" height="50" class="mb-3" alt="Logo">
                    <h2 class="fw-bold" style="font-family: 'Outfit';">Join the Portal</h2>
                </div>
                
                <h3 class="mb-4 fw-bold" style="font-family: 'Outfit'; color: var(--md-primary);">Create Account</h3>
                
                <form method="POST" action="{{ route('signup.submit') }}">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control elegant-input" id="nameInput" name="name" placeholder="Full Name" required>
                                <label for="nameInput" class="text-secondary">Full Name</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control elegant-input" id="emailInput" name="email" placeholder="name@example.com" required>
                                <label for="emailInput" class="text-secondary">Email address</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control elegant-input" id="phoneInput" name="phone" placeholder="080..." required>
                                <label for="phoneInput" class="text-secondary">Phone Number</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control elegant-input" id="passwordInput" name="password" placeholder="Password" required>
                                <label for="passwordInput" class="text-secondary">Password</label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-lg btn-md-primary w-100 py-3 fs-5 shadow-sm mt-2">
                        Register Account
                    </button>
                    
                    <div class="text-center mt-4 pt-3 border-top">
                        <span class="text-secondary">Already have an account?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--md-primary);">Login here</a>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<style>
    .min-vh-75 { min-height: 75vh; }
    .elegant-input {
        border-radius: 12px;
        border: 1px solid #e1e2ec;
        background-color: #fdfbff;
        transition: all 0.2s ease;
    }
    .elegant-input:focus {
        border-color: var(--md-primary);
        box-shadow: 0 0 0 4px var(--md-primary-container);
        background-color: #ffffff;
    }
    .form-floating > label {
        padding-left: 1.25rem;
    }
    .form-floating > .form-control {
        padding-left: 1.25rem;
    }
</style>
@endsection
