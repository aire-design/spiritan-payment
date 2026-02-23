@extends('layouts.app')

@section('content')
    <div class="row justify-content-center align-items-stretch g-4">
        <div class="col-lg-4">
            <div class="card p-4 h-100 bg-spiritan text-white">
                <h4 class="fw-bold mb-3">Create Parent Access</h4>
                <p class="mb-3">Register once and enjoy secure digital payment services for all school charges.</p>
                <ul class="mb-0">
                    <li>Faster payment checkout</li>
                    <li>Receipt history visibility</li>
                    <li>Reliable transaction records</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-4">
                <h3 class="text-spiritan mb-3">Sign Up</h3>
                <p class="text-muted">Create your parent profile to get started.</p>
                <form method="POST" action="{{ route('signup.submit') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input class="form-control" name="name" placeholder="Parent name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input class="form-control" name="phone" placeholder="080..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="********" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-spiritan w-100 mt-4">Create Account</button>
                </form>
            </div>
        </div>
    </div>
@endsection
