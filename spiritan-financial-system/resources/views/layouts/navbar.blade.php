@php
    $userType = session('user_type', 'guest');
    $userName = session('user_name');
    $isAdmin = in_array($userType, ['admin', 'bursar', 'it_officer'], true);
@endphp

<!-- TOP INFO BAR -->
<div class="bg-spiritan-gradient text-white py-1 d-none d-md-block shadow-sm" style="font-size: 0.8rem; letter-spacing: 0.02em;">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-4 opacity-75">
            <div class="d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                Sabon Lugbe, Airport Road, Abuja Nigeria
            </div>
            <div class="d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>
                +234 703 165 8535
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 opacity-75">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16"><path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/></svg>
            info@spiritan-edu.org
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg sticky-top glass-navbar py-2 py-lg-3" style="z-index: 1030;">
    <div class="container">
        <!-- Brand / Logo -->
        <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('landing') }}">
            <img src="{{ asset('logo.png') }}" alt="Spiritan Logo" class="brand-logo">
            <div class="brand-text d-flex flex-column justify-content-center">
                <span class="fw-bold lh-1 brand-title" style="font-family: 'Outfit'; color: var(--md-on-surface);">Spiritan <span style="color: var(--md-primary);">DFMS</span></span>
                <small class="text-secondary fw-medium brand-subtitle" style="text-transform: uppercase;">Int'l Girls' School</small>
            </div>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 shadow-none p-2 rounded-circle ms-auto btn-hover-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation" style="color: var(--md-on-surface);">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse bg-white-mobile mt-3 mt-lg-0 rounded-4 p-4 p-lg-0 shadow-sm-mobile" id="mainNav">
            <ul class="navbar-nav mx-auto align-items-lg-center gap-1 gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('landing') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('landing') }}">Home</a>
                </li>

                @if($isAdmin)
                    <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('dashboard') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('students.*') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('students.index') }}">Students</a></li>
                    <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('classes.*') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('classes.index') }}">Classes</a></li>
                    <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('terms.*') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('terms.index') }}">Terms</a></li>
                    <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('purposes.*') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('purposes.index') }}">Purposes</a></li>
                    <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('fees.*') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('fees.index') }}">Fees</a></li>
                    <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('payments.*') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('payments.index') }}">Payments</a></li>
                    <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('reports.*') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('reports.index') }}">Reports</a></li>
                @else
                    @if($userType === 'parent')
                        <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('parent.history') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('parent.history') }}">Payment History</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link px-3 py-2 fw-medium rounded-pill {{ Route::is('pay.create') ? 'active text-primary bg-primary bg-opacity-10' : 'text-secondary nav-link-hover' }}" href="{{ route('pay.create') }}">Make Payment</a></li>
                @endif
            </ul>
            
            <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 mt-4 mt-lg-0 pt-4 pt-lg-0 border-top border-lg-0 border-light border-opacity-50">
                @if($userType === 'guest')
                    <a class="nav-link px-4 py-2 fw-bold text-secondary nav-link-hover text-center" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-primary px-4 py-2 rounded-pill fw-medium shadow-sm transition-all text-white" style="background: var(--md-primary); border: none;" href="{{ route('signup') }}">Get Started</a>
                @else
                    <div class="d-flex align-items-center gap-2 mb-3 mb-lg-0 justify-content-center">
                        <div class="avatar-circle">
                            <span class="fw-bold">{{ strtoupper(substr($userName ?? $userType, 0, 1)) }}</span>
                        </div>
                        <div class="d-flex flex-column lh-1">
                            <span class="fw-bold small text-dark">{{ $userName ?? 'User' }}</span>
                            <span class="text-muted" style="font-size: 0.7rem;">{{ ucfirst(str_replace('_', ' ', $userType)) }}</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="btn btn-outline-secondary btn-sm rounded-pill px-4 py-2 w-100 fw-medium transition-all" type="submit">Logout</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navbar Styles */
    .glass-navbar {
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(0,0,0,0.06);
        transition: all 0.3s ease;
    }
    
    .brand-logo {
        height: 40px;
        width: auto;
        transition: transform 0.3s ease;
    }
    
    .brand-logo:hover {
        transform: scale(1.05);
    }
    
    .brand-title {
        font-size: 1.25rem;
        letter-spacing: -0.02em;
    }
    
    .brand-subtitle {
        font-size: 0.65rem;
        letter-spacing: 0.08em;
    }

    .nav-link-hover {
        transition: all 0.2s ease;
    }
    
    .nav-link-hover:hover {
        background-color: var(--md-surface-variant);
        color: var(--md-on-surface) !important;
    }

    .avatar-circle {
        width: 32px;
        height: 32px;
        background-color: var(--md-secondary-container);
        color: var(--md-on-secondary-container);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }

    .btn-hover-light:focus, .btn-hover-light:active {
        background-color: var(--md-surface-variant) !important;
    }
    
    .transition-all {
        transition: all 0.2s ease;
    }
    
    .transition-all:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05) !important;
    }

    @media (min-width: 992px) {
        .brand-logo { height: 46px; }
        .brand-title { font-size: 1.4rem; }
        .glass-navbar { padding: 0.5rem 0 !important; }
        .bg-white-mobile { background: transparent !important; }
        .shadow-sm-mobile { box-shadow: none !important; }
    }
    
    @media (max-width: 991.98px) {
        .bg-white-mobile { 
            background: #ffffff; 
            border: 1px solid rgba(0,0,0,0.05);
        }
        .shadow-sm-mobile { box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1) !important; }
        .navbar-collapse {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            margin: 0.5rem 1rem;
            z-index: 1050;
        }
    }
</style>
