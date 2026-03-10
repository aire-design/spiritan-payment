@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center g-5 min-vh-75">
        
        <!-- Elegant Information Side -->
        <div class="col-lg-5 d-none d-lg-block animate__animated animate__fadeInLeft">
            <div class="pe-4">
                <div class="badge rounded-pill mb-3 px-3 py-2" style="background: var(--md-primary-container); color: var(--md-on-primary-container); font-family: 'Outfit'; font-weight: 500;">
                    Secure Portal
                </div>
                <h1 class="display-5 fw-bold mb-4" style="font-family: 'Outfit'; color: var(--md-on-surface);">Welcome Back</h1>
                <p class="lead mb-5 text-secondary" style="font-size: 1.15rem; line-height: 1.6;">
                    Access your secure school finance portal to manage payments, track receipts, and view financial reports efficiently.
                </p>
                
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: #eef2ff; color: var(--md-primary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16"><path d="M8 14.933a.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.531.43 8.527.18 8 0c-.528.18-1.531.43-2.618.724-1.114.3-2.204.646-2.837.855a.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.294.118a.617.617 0 0 0 .1.025zM7.23 10.153l-2-2a.5.5 0 1 1 .707-.707L7.23 8.739l4.146-4.147a.5.5 0 1 1 .708.707l-4.5 4.5a.5.5 0 0 1-.307.147z"/></svg>
                        </div>
                        <span class="fs-5 text-secondary fw-medium">Trusted Payment Verification</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: #fff4f4; color: var(--md-error);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/></svg>
                        </div>
                        <span class="fs-5 text-secondary fw-medium">Instant Receipt Generation</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Elegant Form Side -->
        <div class="col-lg-5 col-md-8 animate__animated animate__fadeInRight">
            <div class="card md-card border-0 p-4 p-md-5">
                <div class="text-center mb-4 d-lg-none">
                    <img src="{{ asset('logo.png') }}" height="60" class="mb-3" alt="Logo">
                    <h2 class="fw-bold" style="font-family: 'Outfit';">Welcome Back</h2>
                </div>
                
                <h3 class="mb-4 fw-bold" style="font-family: 'Outfit'; color: var(--md-primary);">Login</h3>
                
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    
                    <div class="form-floating mb-4">
                        <input type="email" class="form-control elegant-input" id="emailInput" name="email" placeholder="name@example.com" required>
                        <label for="emailInput" class="text-secondary">Email address</label>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control elegant-input" id="passwordInput" name="password" placeholder="Password" required>
                        <label for="passwordInput" class="text-secondary">Password</label>
                    </div>
                    
                    <div class="form-floating mb-5">
                        <select class="form-select elegant-input" id="roleSelect" name="user_type" required>
                            <option value="parent" selected>Parent / Payer</option>
                            <option value="admin">Administrator</option>
                            <option value="bursar">Bursar</option>
                            <option value="it_officer">IT Officer</option>
                        </select>
                        <label for="roleSelect" class="text-secondary">Login As</label>
                    </div>
                    
                    <button type="submit" class="btn btn-lg btn-md-primary w-100 py-3 fs-5 shadow-sm">
                        Continue to Portal
                    </button>
                    
                    <div class="text-center mt-4 pt-3 border-top">
                        <span class="text-secondary">Don't have an account?</span>
                        <a href="{{ route('signup') }}" class="text-decoration-none fw-bold" style="color: var(--md-primary);">Create one</a>
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
    .form-floating > .form-select {
        padding-left: 1.25rem;
    }
</style>
@endsection
