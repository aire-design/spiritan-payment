<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class ParentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $email = session('parent_email');

        if (! $email) {
            return redirect()->route('login')->with('error', 'Please log in to view your history.');
        }

        // Fetch all successful and pending payments for this parent's email.
        $payments = Payment::with(['student', 'fee'])
            ->where('payer_email', $email)
            ->latest()
            ->paginate(15);

        // Grouping logic for "by term and session"
        // In a real app we would have a Term or Session relationship.
        // Assuming we map from existing data or summarize.
        $totalPaid = Payment::where('payer_email', $email)->where('status', 'success')->sum('amount_paid');
        $totalPending = Payment::where('payer_email', $email)->where('status', 'pending')->count();

        return view('parent.history', compact('payments', 'totalPaid', 'totalPending'));
    }
}
