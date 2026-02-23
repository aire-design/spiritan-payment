@extends('layouts.app')

@section('full_width_content')
<!-- ELEGANT HERO SECTION -->
<div class="mb-5 landing-hero position-relative overflow-hidden shadow-lg" style="background: url('{{ asset('hero-bg.png') }}') center/cover no-repeat; min-height: 55vh; display: flex; align-items: center;">
    
    <!-- Dark/Navy Overlay for Text Readability -->
    <div class="position-absolute w-100 h-100 top-0 start-0" style="background: linear-gradient(135deg, rgba(3, 20, 50, 0.98) 0%, rgba(11, 61, 145, 0.85) 60%, rgba(11, 61, 145, 0.3) 100%);"></div>
    
    <div class="container position-relative z-index-1 py-5">
        <div class="row align-items-center">
            <div class="col-lg-8 col-xl-7 text-center text-lg-start animate__animated animate__fadeInUp p-4 p-md-5 rounded-4" style="background: rgba(0, 0, 0, 0.2); backdrop-filter: blur(5px);">
                
                <div class="badge rounded-pill px-4 py-2 mb-4 shadow mx-auto ms-lg-0" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); font-weight: 600; font-family: 'Outfit'; backdrop-filter: blur(10px); color: #fff; letter-spacing: 0.03em;">
                    ✨ Spiritan International Girls' School
                </div>
                
                <h1 class="hero-title fw-bold mb-4 text-white" style="font-family: 'Outfit'; line-height: 1.15; text-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                    Digital Financial <br class="d-none d-md-block">
                    <span style="color: #ffd700;">Management System</span>
                </h1>
                
                <p class="lead mb-4 text-white opacity-85 mx-auto ms-lg-0 hero-subtitle" style="max-width: 650px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    A secure, elegant, and efficient way to manage school fees and financial records for excellence in education.
                </p>
                
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('pay.create') }}" class="btn btn-lg px-5 py-3 shadow-lg btn-hero-primary d-flex align-items-center justify-content-center gap-2 w-100 w-sm-auto" style="background: #ffffff; color: var(--md-primary); border-radius: 100px; font-weight: 700; font-family: 'Outfit'; transition: all 0.3s ease;">
                        Make Payment
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/></svg>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-lg px-5 py-3 btn-hero-outline w-100 w-sm-auto" style="background: rgba(255,255,255,0.1); color: white; border: 1.5px solid rgba(255,255,255,0.4); border-radius: 100px; font-weight: 600; font-family: 'Outfit'; backdrop-filter: blur(8px); transition: all 0.3s ease;">
                        Login to Portal
                    </a>
                </div>
                
                <div class="mt-4 pt-4 d-flex flex-column flex-sm-row align-items-center gap-4 justify-content-center justify-content-lg-start text-white opacity-75 border-top border-light border-opacity-25" style="max-width: 600px;">
                    <div class="d-flex align-items-center gap-2" style="font-weight: 500;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16"><path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.294.118a.616.616 0 0 0 .1.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.531.43 8.527.18 8 0c-.528.18-1.531.43-2.618.724zM8 10.5c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3zm0-5a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>
                        <span>Secure SSL Encryption</span>
                    </div>
                    <div class="d-flex align-items-center gap-2" style="font-weight: 500;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/></svg>
                        <span>Instant Verification</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <!-- Feature Cards -->
        <div class="col-md-4">
            <div class="md-card h-100 border-0 shadow-sm">
                <div class="feature-icon mb-4 d-inline-flex p-3 rounded-4" style="background: #eef2ff; color: #0b3d91;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                </div>
                <h3>Student Portal</h3>
                <p class="text-secondary">Students and parents can easily view outstanding fees and payment history in one place.</p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="md-card h-100 border-0 shadow-sm">
                <div class="feature-icon mb-4 d-inline-flex p-3 rounded-4" style="background: #fff4f4; color: #ba1a1a;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
                        <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.5-1.5H2V1.78a1.5 1.5 0 0 1 1.864-1.454L12.136.326zM14 5.5H1.5v8h13v-8zM5 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                </div>
                <h3>Seamless Payments</h3>
                <p class="text-secondary">Pay school fees using various methods with instant receipt generation and verification.</p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="md-card h-100 border-0 shadow-sm">
                <div class="feature-icon mb-4 d-inline-flex p-3 rounded-4" style="background: #fbf0ff; color: #715573;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.13a.5.5 0 0 1-.708.047L7.111 7.203l-3.4 4.534a.5.5 0 0 1-.8-.6l3.722-4.963a.5.5 0 0 1 .714-.042l2.007 1.764L12.8 4.5H10.5a.5.5 0 0 1-.5-.5Z"/>
                    </svg>
                </div>
                <h3>Smart Reporting</h3>
                <p class="text-secondary">Administrators can generate real-time financial reports to track the school's fiscal health.</p>
            </div>
        </div>
    </div>

    <!-- Additional Info Section -->
    <div class="mt-5 p-5 bg-white rounded-4 shadow-sm text-center border mb-3">
        <h2 class="mb-4">Excellence in Spiritan Education</h2>
        <p class="mx-auto text-secondary mb-0" style="max-width: 800px;">Our Digital Financial Management System is designed to support the academic journey of our students by ensuring transparency and ease of financial transactions for parents and guardians.</p>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate__fadeInUp {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    @keyframes zoomIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate__zoomIn {
        animation: zoomIn 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    .landing-hero {
        margin-top: -1.5rem; /* Join with navbar more tightly */
    }
</style>
@endsection
