@extends('layouts.app')

@section('content')
    <div class="row justify-content-center align-items-stretch g-4">
        <div class="col-lg-5">
            <div class="card p-4 h-100 bg-spiritan text-white">
                <h4 class="fw-bold mb-3">Welcome Back</h4>
                <p class="mb-4">Access your secure school finance portal to manage payments, receipts, and reports efficiently.</p>
                <ul class="mb-0">
                    <li>Trusted payment verification</li>
                    <li>Role-based dashboard experience</li>
                    <li>Instant receipt and audit trail</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card p-4">
                <h3 class="text-spiritan mb-3">Login</h3>
                <p class="text-muted">Sign in to continue to Spiritan DFMS.</p>
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="********" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Login As</label>
                        <select class="form-select" name="user_type" required>
                            <option value="parent">Parent / Payer</option>
                            <option value="admin">Administrator</option>
                            <option value="bursar">Bursar</option>
                            <option value="it_officer">IT Officer</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-spiritan w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
