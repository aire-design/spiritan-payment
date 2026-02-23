<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Spiritan DFMS - Digital Financial Management System</title>

    <!-- Professional Favicons via the public folder -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Material Design 3 Tonal Palette - Spiritan Blue Theme */
            --md-primary: #0b3d91;
            --md-on-primary: #ffffff;
            --md-primary-container: #d8e2ff;
            --md-on-primary-container: #001a41;
            
            --md-secondary: #565e71;
            --md-on-secondary: #ffffff;
            --md-secondary-container: #dae2f9;
            --md-on-secondary-container: #131c2b;
            
            --md-tertiary: #715573;
            --md-on-tertiary: #ffffff;
            --md-tertiary-container: #fbd7fc;
            --md-on-tertiary-container: #29132d;
            
            --md-error: #ba1a1a;
            --md-on-error: #ffffff;
            
            --md-surface: #fdfbff;
            --md-on-surface: #1a1b1f;
            --md-surface-variant: #e1e2ec;
            --md-on-surface-variant: #44474f;
            --md-outline: #74777f;
            
            /* Elevations (Material Design 3 Shadows) */
            --elevation-1: 0px 1px 3px 1px rgba(0, 0, 0, 0.15), 0px 1px 2px 0px rgba(0, 0, 0, 0.30);
            --elevation-2: 0px 2px 6px 2px rgba(0, 0, 0, 0.15), 0px 1px 2px 0px rgba(0, 0, 0, 0.30);
            --elevation-3: 0px 4px 8px 3px rgba(0, 0, 0, 0.15), 0px 1px 3px 0px rgba(0, 0, 0, 0.30);
        }

        body { 
            background-color: #f8f9ff; 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
            color: var(--md-on-surface);
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .md-card {
            background: var(--md-surface);
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--elevation-1);
            transition: box-shadow 0.3s ease, transform 0.2s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .md-card:hover {
            box-shadow: var(--elevation-2);
        }

        .btn-md-primary {
            background-color: var(--md-primary);
            color: var(--md-on-primary);
            border-radius: 100px;
            padding: 10px 24px;
            font-weight: 500;
            border: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-md-primary:hover {
            background-color: #1a4da6;
            box-shadow: var(--elevation-1);
            transform: translateY(-1px);
        }

        .btn-md-tonal {
            background-color: var(--md-secondary-container);
            color: var(--md-on-secondary-container);
            border-radius: 100px;
            padding: 10px 24px;
            font-weight: 500;
            border: none;
            transition: all 0.2s ease;
        }

        .bg-spiritan-gradient {
            background: linear-gradient(135deg, var(--md-primary) 0%, #001e54 100%);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
@include('layouts.navbar')

    @if(session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="container mt-4">
            <div class="alert alert-danger">
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @hasSection('full_width_content')
        @yield('full_width_content')
    @else
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    @endif

    <footer class="bg-white border-top mt-auto py-4">
        <div class="container text-center">
            <div class="d-flex justify-content-center flex-wrap gap-3 mb-3 text-secondary small">
                <span>Sabon Lugbe, Airport Road, Abuja Nigeria</span>
                <span class="d-none d-md-inline text-muted" style="opacity: 0.5;">|</span>
                <span>+234 703 165 8535</span>
                <span class="d-none d-md-inline text-muted" style="opacity: 0.5;">|</span>
                <span>info@spiritan-edu.org</span>
            </div>
            <div class="d-flex justify-content-center align-items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="Logo Small" style="height:24px; filter: grayscale(1); opacity: 0.6;">
                <div class="vr" style="height: 15px;"></div>
                <span class="text-muted small">Spiritan International Girls' School © {{ date('Y') }}. All rights reserved.</span>
            </div>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
