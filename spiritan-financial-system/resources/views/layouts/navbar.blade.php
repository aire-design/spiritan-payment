@php
    $userType = session('user_type', 'guest');
    $userName = session('user_name');
    $isAdmin = in_array($userType, ['admin', 'bursar', 'it_officer'], true);
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-spiritan shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('landing') }}">
            <span class="d-inline-flex justify-content-center align-items-center rounded-3" style="width:36px;height:36px;background:rgba(255,255,255,.2);font-weight:800;">SG</span>
            <span>
                <span class="fw-bold d-block lh-1">Spiritan DFMS</span>
                <small class="opacity-75" style="font-size:.68rem;">International Girls' School</small>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavShared">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavShared">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link" href="{{ route('landing') }}">Home</a></li>

                @if($isAdmin)
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('students.index') }}">Students</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('fees.index') }}">Fees</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('payments.index') }}">Payments</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">Reports</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('pay.create') }}">Make Payment</a></li>
                @endif

                @if($userType === 'guest')
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-sm btn-danger px-3" href="{{ route('signup') }}">Sign Up</a></li>
                @else
                    <li class="nav-item">
                        <span class="badge school-badge rounded-pill px-3 py-2">{{ strtoupper(str_replace('_', ' ', $userType)) }}{{ $userName ? ' • '.$userName : '' }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-outline-light ms-lg-2" type="submit">Logout</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
