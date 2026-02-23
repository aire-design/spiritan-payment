<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spiritan School Payment Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --sp-blue:#0b3d91; --sp-red:#dc2626; --sp-dark:#0f172a; }
        body { background:#f6f8fc; color:var(--sp-dark); }
        .navbar-brand-mark {
            width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, var(--sp-blue), #163e86);
            color:#fff; display:grid; place-items:center; font-weight:700;
        }
        .hero-wrap {
            background: radial-gradient(circle at 15% 20%, #e7efff, #f9fbff 45%, #ffffff);
            border-radius: 24px;
            border: 1px solid #e5ebf7;
            box-shadow: 0 20px 50px rgba(2, 15, 38, 0.08);
        }
        .hero-title { font-size: clamp(2rem, 4vw, 3.1rem); font-weight: 800; color: var(--sp-blue); }
        .btn-sp { background: var(--sp-red); color:#fff; border-color:var(--sp-red); }
        .btn-sp:hover { background:#b91c1c; color:#fff; }
        .feature-card {
            border: 1px solid #e7edf8;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
        }
        .hero-image {
            min-height: 360px;
            border-radius: 16px;
            background-image: linear-gradient(to top, rgba(11,61,145,.55), rgba(11,61,145,.15)),
                url('https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.15);
            display: flex;
            align-items: end;
            color: #fff;
        }
        .metric { background:#fff; border:1px solid #e6ebf6; border-radius:14px; }
        .dot { width: 10px; height: 10px; border-radius: 50%; background: #22c55e; display:inline-block; }
    </style>
</head>
<body>
    @include('layouts.navbar')

    <section class="py-5 py-lg-6">
        <div class="container">
            <div class="hero-wrap p-4 p-lg-5 mb-4">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-7">
                        <span class="d-inline-flex align-items-center gap-2 bg-white border rounded-pill px-3 py-2 mb-3 small text-muted">
                            <span class="dot"></span> Live payment portal for Spiritan International Girls' School
                        </span>
                        <h1 class="hero-title mb-3">Modern School Fee Collection, Built for Parents and Administrators</h1>
                        <p class="lead text-muted mb-4">Pay tuition and levies securely, get instant PDF receipts, and keep school finance records transparent and organized.</p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <a href="{{ route('login') }}" class="btn btn-sp btn-lg px-4">Login</a>
                            <a href="{{ route('signup') }}" class="btn btn-outline-primary btn-lg px-4">Create Account</a>
                            <a href="{{ route('pay.create') }}" class="btn btn-outline-secondary btn-lg px-4">Pay Now</a>
                        </div>
                        <small class="text-muted">Powered by Laravel + Paystack with secure webhook verification.</small>
                    </div>
                    <div class="col-lg-5">
                        <div class="hero-image p-4">
                            <div>
                                <h5 class="fw-bold mb-1">Empowering Better School Finance</h5>
                                <p class="mb-0 small">A secure digital platform designed for parents, bursars, and school administrators.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4"><div class="metric p-3"><div class="small text-muted">Payment Methods</div><div class="h5 mb-0">Paystack / Bank / Cash</div></div></div>
                <div class="col-md-4"><div class="metric p-3"><div class="small text-muted">Receipt Format</div><div class="h5 mb-0">PDF + Email Copy</div></div></div>
                <div class="col-md-4"><div class="metric p-3"><div class="small text-muted">Report Export</div><div class="h5 mb-0">CSV & Excel</div></div></div>
            </div>
        </div>
    </section>

    <footer class="border-top bg-white py-3">
        <div class="container small text-muted d-flex flex-column flex-md-row justify-content-between">
            <span>© {{ date('Y') }} Spiritan International Girls' School</span>
            <span>Secure Digital Financial Management System</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
