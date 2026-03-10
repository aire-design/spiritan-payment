<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $totalPaid = Payment::where('status', 'success')->sum('amount_paid');
        $recentPayments = Payment::with(['student', 'fee'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact('totalStudents', 'activeStudents', 'totalPaid', 'recentPayments'));
    }
}
