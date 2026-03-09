<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicPaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    if ($data['user_type'] === 'parent') {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'role' => 'parent'])) {
            $request->session()->regenerate();
            session([
                'user_type' => 'parent',
                'user_name' => Auth::user()->name,
                'parent_email' => Auth::user()->email,
            ]);
            return redirect()->route('parent.history')->with('success', 'Welcome back.');
        }
        return back()->withErrors(['email' => 'Invalid credentials for parent portal.']);
    }

    // Admin login logic (currently spoofed as per previous requirements)
    if (in_array($data['user_type'], ['admin', 'bursar', 'it_officer'], true)) {
        session([
            'user_type' => $data['user_type'],
            'user_name' => explode('@', $data['email'])[0],
            'parent_email' => $data['email'],
        ]);
        return redirect()->route('dashboard')->with('success', 'Welcome back, administrator.');
    }

    return back()->withErrors(['email' => 'Invalid user type.']);
})->name('login.submit');

Route::get('/signup', fn () => view('auth.signup'))->name('signup');
Route::post('/signup', function (Request $request) {
    $data = $request->validate([
        'first_name' => ['required', 'string', 'max:50'],
        'last_name' => ['required', 'string', 'max:50'],
        'email' => ['required', 'email', 'unique:users,email'],
        'phone' => ['required', 'string', 'max:25'],
        'password' => ['required', 'string', 'min:6'],
    ]);

    $user = User::create([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'role' => 'parent',
        'password' => Hash::make($data['password']),
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    session([
        'user_type' => 'parent',
        'user_name' => $user->name,
        'parent_email' => $user->email,
    ]);

    return redirect()->route('parent.history')->with('success', 'Account profile created successfully.');
})->name('signup.submit');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    session()->forget(['user_type', 'user_name', 'parent_email']);

    return redirect()->route('landing')->with('success', 'You have been logged out.');
})->name('logout');

// Parent Profile Routes
Route::middleware(\App\Http\Middleware\RedirectIfNotAuthenticated::class)->group(function () {
    Route::get('/profile', function () {
        return view('parent.profile');
    })->name('profile.edit');

    Route::patch('/profile', function (Request $request) {
        $user = Auth::user();
        
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'phone' => ['required', 'string', 'max:25'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        
        $user->save();

        session([
            'user_name' => $user->name,
            'parent_email' => $user->email,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    })->name('profile.update');
});

Route::get('/pay/fee-lookup', [PublicPaymentController::class, 'feeLookup'])->name('pay.feeLookup');
Route::get('/pay/students-by-class', [PublicPaymentController::class, 'studentsByClass'])->name('pay.studentsByClass');
Route::get('/pay', [PublicPaymentController::class, 'create'])->name('pay.create');
Route::post('/pay', [PublicPaymentController::class, 'store'])->name('pay.store');
Route::get('/pay/verify/{payment}', [PublicPaymentController::class, 'verify'])->name('pay.verify');
Route::get('/pay/receipt/{payment}', [PublicPaymentController::class, 'receipt'])->name('pay.receipt');
Route::get('/pay/receipt/{payment}/pdf', [PublicPaymentController::class, 'receiptPdf'])->name('pay.receipt.pdf');

Route::get('/history', [\App\Http\Controllers\ParentDashboardController::class, 'index'])->name('parent.history');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('students', StudentController::class)->except(['edit', 'update', 'destroy']);
Route::resource('fees', FeeController::class)->except(['edit', 'update', 'destroy']);
Route::resource('payments', PaymentController::class)->except(['edit', 'update', 'destroy']);
Route::resource('classes', App\Http\Controllers\SchoolClassController::class);
Route::resource('terms', App\Http\Controllers\TermController::class);
Route::resource('purposes', App\Http\Controllers\PaymentPurposeController::class);
Route::resource('academic-sessions', App\Http\Controllers\AcademicSessionController::class);

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');
Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
