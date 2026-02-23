@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center g-5 min-vh-75">
        
        <!-- Elegant Information Side -->
        <div class="col-lg-4 d-none d-lg-block animate__animated animate__fadeInLeft">
            <div class="pe-4">
                <div class="badge rounded-pill mb-3 px-3 py-2" style="background: var(--md-tertiary-container); color: var(--md-on-tertiary-container); font-family: 'Outfit'; font-weight: 500;">
                    Secure Checkout
                </div>
                <h1 class="display-6 fw-bold mb-4" style="font-family: 'Outfit'; color: var(--md-on-surface);">Make a Payment</h1>
                <p class="mb-5 text-secondary" style="font-size: 1.1rem; line-height: 1.6;">
                    Easily complete school fee payments online. All transactions are encrypted and secured by Paystack.
                </p>
                
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: #eef2ff; color: var(--md-primary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16"><path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.294.118a.616.616 0 0 0 .1.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.531.43 8.527.18 8 0c-.528.18-1.531.43-2.618.724zM8 10.5c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3zm0-5a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>
                        </div>
                        <span class="text-secondary fw-medium">Bank-level Security</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: #fbf0ff; color: var(--md-tertiary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope-check" viewBox="0 0 16 16"><path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/><path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686Z"/></svg>
                        </div>
                        <span class="text-secondary fw-medium">Instant E-Receipts</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Elegant Form Side -->
        <div class="col-lg-8 animate__animated animate__fadeInRight">
            <div class="card md-card border-0 p-4 p-md-5">
                <div class="text-center mb-4 d-lg-none">
                    <img src="{{ asset('logo.png') }}" height="50" class="mb-3" alt="Logo">
                    <h2 class="fw-bold" style="font-family: 'Outfit';">Make a Payment</h2>
                </div>
                
                <h3 class="mb-4 fw-bold d-none d-lg-block" style="font-family: 'Outfit'; color: var(--md-primary);">Payment Details</h3>
                
                <form method="POST" action="{{ route('pay.store') }}">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control elegant-input" id="studentNameInput" name="student_full_name" placeholder="Student Full Name" required>
                                <label for="studentNameInput" class="text-secondary">Student Full Name</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control elegant-input" id="admissionNumberInput" name="admission_number" placeholder="Admission Number" required>
                                <label for="admissionNumberInput" class="text-secondary">Admission Number</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select elegant-input" id="classSelect" name="class_name" required>
                                    <option value="" selected disabled>Select Class/Grade</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->name }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                <label for="classSelect" class="text-secondary">Class / Grade</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control elegant-input" id="parentEmailInput" name="parent_email" placeholder="name@example.com" required>
                                <label for="parentEmailInput" class="text-secondary">Parent Email</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control elegant-input" id="parentPhoneInput" name="parent_phone" placeholder="080..." required>
                                <label for="parentPhoneInput" class="text-secondary">Parent Phone Number</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <select class="form-select elegant-input" id="feeSelect" name="fee_id" required>
                                    <option value="" selected disabled>Select Fee / Payment Purpose</option>
                                    @foreach($fees as $fee)
                                        <option value="{{ $fee->id }}">{{ $fee->name }} @if(!$fee->is_variable)- ₦{{ number_format($fee->amount, 2) }}@endif</option>
                                    @endforeach
                                </select>
                                <label for="feeSelect" class="text-secondary">Fee / Payment Purpose</label>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" step="0.01" class="form-control elegant-input" id="amountInput" name="amount" placeholder="Amount (for variable fee only)">
                                <label for="amountInput" class="text-secondary">Amount (for variable fee only)</label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-lg btn-md-primary w-100 py-3 fs-5 shadow-sm mt-3 d-flex align-items-center justify-content-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/><path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/></svg>
                        Proceed to Secure Checkout
                    </button>
                    
                    <div class="text-center mt-4">
                        <img src="https://js.paystack.co/v1/inline/images/paystack.png" style="height: 30px; opacity: 0.8;" alt="Secured by Paystack">
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
