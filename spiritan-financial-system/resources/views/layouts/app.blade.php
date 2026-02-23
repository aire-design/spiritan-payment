<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Spiritan Financial System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --spiritan-blue: #0b3d91;
            --spiritan-red: #dc2626;
            --spiritan-ink: #0f172a;
        }
        body { background: #f4f6fb; font-family: 'Inter', sans-serif; color: var(--spiritan-ink); }
        .bg-spiritan { background: linear-gradient(90deg, var(--spiritan-blue), #102a62); }
        .text-spiritan { color: var(--spiritan-blue); }
        .btn-spiritan { background: var(--spiritan-red); color: #fff; border-color: var(--spiritan-red); }
        .btn-spiritan:hover { background: #b91c1c; color: #fff; }
        .card { border: none; box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06); }
        .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: .03em; }
        .school-badge { background: rgba(255,255,255,.2); color:#fff; border:1px solid rgba(255,255,255,.4); }
    </style>
</head>
<body>
@include('layouts.navbar')

<main class="py-4">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
