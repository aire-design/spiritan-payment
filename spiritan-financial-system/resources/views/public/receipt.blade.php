@extends('layouts.app')

@section('content')
<div class="container py-5 min-vh-75 d-flex align-items-center justify-content-center">
    <div class="col-lg-7 col-xl-6 animate__animated animate__fadeInUp">
        
        <div class="card md-card border-0 p-0 overflow-hidden text-center">
            
            <!-- Success Header Header -->
            <div class="{{ $payment->status === 'success' ? 'bg-success' : ($payment->status === 'pending' ? 'bg-warning' : 'bg-danger') }} bg-opacity-10 py-5 border-bottom px-4 position-relative">
                <div class="mb-3 d-flex justify-content-center">
                    @if($payment->status === 'success')
                        <div class="bg-white p-3 rounded-circle shadow-sm" style="color: #198754;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                        </div>
                    @elseif($payment->status === 'pending')
                        <div class="bg-white p-3 rounded-circle shadow-sm text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/></svg>
                        </div>
                    @else
                        <div class="bg-white p-3 rounded-circle shadow-sm text-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/></svg>
                        </div>
                    @endif
                </div>
                
                <h3 class="fw-bold mb-1" style="font-family: 'Outfit';">
                    @if($payment->status === 'success') Payment Successful
                    @elseif($payment->status === 'pending') Payment Pending
                    @else Payment Failed
                    @endif
                </h3>
                <p class="text-secondary mb-0 small">Transaction Ref: <span class="fw-bold user-select-all">{{ $payment->payment_reference }}</span></p>
                <h1 class="display-4 fw-bold mt-4 mb-0" style="color: var(--md-on-surface); font-family: 'Outfit';">₦{{ number_format($payment->amount_paid, 2) }}</h1>
            </div>

            <!-- Receipt Details Structure -->
            <div class="p-4 p-md-5 text-start">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <img src="{{ asset('logo.png') }}" height="32" class="opacity-75" alt="Spiritan Logo">
                    <div class="text-end lh-1">
                        <small class="text-secondary fw-semibold d-block mb-1">DATE</small>
                        <span class="text-dark small">{{ optional($payment->paid_at)->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A') }}</span>
                    </div>
                </div>

                <div class="bg-light rounded-4 p-4 mb-4 border" style="border-style: dashed !important; border-color: #dee2e6 !important;">
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-secondary small fw-medium">Student Info</span>
                            </div>
                            <div class="fw-bold">{{ $payment->student_full_name ?? 'N/A' }}</div>
                            <div class="small text-muted">{{ $payment->class_name ?? 'N/A' }} &bull; {{ $payment->admission_number ?? 'N/A' }}</div>
                        </div>
                        
                        <div class="col-12"><hr class="my-2 border-secondary opacity-25"></div>
                        
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-secondary small fw-medium">Payment Purpose</span>
                            </div>
                            <div class="fw-bold">{{ $payment->payment_purpose ?? 'School Fee Payment' }}</div>
                        </div>

                        <div class="col-12"><hr class="my-2 border-secondary opacity-25"></div>

                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-secondary small fw-medium">Initiator</span>
                            </div>
                            <div class="small fw-medium">{{ $payment->payer_email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex flex-column gap-3 mt-4">
                    @if($payment->status === 'success')
                        <a href="{{ route('pay.receipt.pdf', $payment) }}" class="btn btn-lg btn-primary w-100 fw-medium shadow-sm rounded-pill d-flex justify-content-center align-items-center gap-2" style="background: var(--md-primary); border: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16"><path d="M5.523 12.424c.14-.082.293-.162.459-.238a7.878 7.878 0 0 1-.45.606c-.28.337-.498.516-.635.572a.266.266 0 0 1-.035.012.282.282 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548zm2.455-1.647c-.119.025-.237.05-.356.078a21.148 21.148 0 0 0 .5-1.05 12.045 12.045 0 0 0 .51.858c-.217.032-.436.07-.654.114zm2.525.939a3.881 3.881 0 0 1-.435-.41c.228.005.434.022.612.054.317.057.466.147.518.209a.095.095 0 0 1 .026.064.436.436 0 0 1-.06.2.307.307 0 0 1-.094.124.107.107 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256zM8.278 6.97c-.04.244-.108.524-.2.829a4.86 4.86 0 0 1-.089-.346c-.076-.353-.087-.73-.04-.961.01-.05.028-.094.053-.13.05-.07.13-.10.20-.10.09 0 .15.05.2.14.05.08.08.2.08.36 0 .23-.04.62-.12.80zm-1.87.5c-.066.08-.13.14-.19.19-.08.06-.16.1-.24.1-.1 0-.15-.05-.15-.15 0-.1.08-.25.22-.4.12-.13.25-.25.4-.36a6.83 6.83 0 0 1-.04.62z"/><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.293 4L9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-1 2.5c.09-.23.15-.52.2-.83.05-.31.1-.64.1-.97 0-.4.1-.73.3-.92.15-.15.4-.2.65-.2.25 0 .5.05.7.15.2.1.3.25.3.45 0 .25-.1.6-.3.9-.2.3-.5.65-.8.95a6.4 6.4 0 0 0-.6 1.4c-.2.5-.4 1-.6 1.5-.1.25-.2.5-.3.75-.1.25-.2.5-.3.75a6.6 6.6 0 0 0-.5 1.4c-.1.3-.2.6-.3.9-.1.2-.2.4-.3.6-.1.1-.2.2-.3.2-.1 0-.2-.1-.2-.2 0-.2.1-.4.2-.6.1-.2.2-.3.3-.4a7.8 7.8 0 0 1 1.2-1.2c.2-.2.4-.3.6-.4.2-.1.4-.2.6-.3a4.7 4.7 0 0 0 .5-.3c.1-.1.2-.2.3-.3.1-.1.1-.2.1-.3 0-.1 0-.2-.1-.3z"/></svg>
                            Download Official PDF Receipt
                        </a>
                    @endif
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pay.create') }}" class="btn btn-md-tonal flex-grow-1 me-2 rounded-pill fw-medium text-center">Make Another Payment</a>
                        @if(session('user_type') === 'parent')
                            <a href="{{ route('parent.history') }}" class="btn btn-outline-secondary flex-grow-1 ms-2 rounded-pill fw-medium text-center">View History</a>
                        @else
                            <a href="{{ route('landing') }}" class="btn btn-outline-secondary flex-grow-1 ms-2 rounded-pill fw-medium text-center">Return Home</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<style>
    .min-vh-75 { min-height: 75vh; }
</style>
@endsection
