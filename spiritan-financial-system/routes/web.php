<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicPaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
        'user_type' => ['required', 'in:parent,admin,bursar,it_officer'],
    ]);

    session([
        'user_type' => $data['user_type'],
        'user_name' => $data['email'],
    ]);

    if (in_array($data['user_type'], ['admin', 'bursar', 'it_officer'], true)) {
        return redirect()->route('dashboard')->with('success', 'Welcome back, administrator.');
    }

    return redirect()->route('pay.create')->with('success', 'Welcome back.');
})->name('login.submit');

Route::get('/signup', fn () => view('auth.signup'))->name('signup');
Route::post('/signup', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email'],
        'phone' => ['required', 'string', 'max:25'],
        'password' => ['required', 'string', 'min:6'],
    ]);

    session([
        'user_type' => 'parent',
        'user_name' => $data['name'],
    ]);

    return redirect()->route('pay.create')->with('success', 'Account profile created successfully.');
})->name('signup.submit');

Route::post('/logout', function () {
    session()->forget(['user_type', 'user_name']);
    return redirect()->route('landing')->with('success', 'You have been logged out.');
})->name('logout');

Route::get('/pay', [PublicPaymentController::class, 'create'])->name('pay.create');
Route::post('/pay', [PublicPaymentController::class, 'store'])->name('pay.store');
Route::get('/pay/verify/{payment}', [PublicPaymentController::class, 'verify'])->name('pay.verify');
Route::get('/pay/receipt/{payment}', [PublicPaymentController::class, 'receipt'])->name('pay.receipt');
Route::get('/pay/receipt/{payment}/pdf', [PublicPaymentController::class, 'receiptPdf'])->name('pay.receipt.pdf');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('students', StudentController::class)->except(['edit', 'update', 'destroy']);
Route::resource('fees', FeeController::class)->except(['edit', 'update', 'destroy']);
Route::resource('payments', PaymentController::class)->except(['edit', 'update', 'destroy']);

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');
Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
