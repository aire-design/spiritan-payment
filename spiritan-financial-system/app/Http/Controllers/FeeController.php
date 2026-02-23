<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\Term;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with(['schoolClass', 'academicSession', 'term'])->latest()->paginate(20);
        return view('fees.index', compact('fees'));
    }

    public function create()
    {
        $classes = SchoolClass::where('is_active', true)->orderBy('name')->get();
        $sessions = AcademicSession::orderByDesc('starts_at')->get();
        $terms = Term::orderByDesc('starts_at')->get();
        return view('fees.create', compact('classes', 'sessions', 'terms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:100'],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
            'academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'term_id' => ['nullable', 'exists:terms,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'is_variable' => ['nullable', 'boolean'],
            'late_fee_penalty' => ['nullable', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_variable'] = (bool) ($data['is_variable'] ?? false);
        $data['is_active'] = (bool) ($data['is_active'] ?? true);

        Fee::create($data);

        return redirect()->route('fees.index')->with('success', 'Fee created successfully.');
    }

    public function show(Fee $fee)
    {
        $fee->load(['schoolClass', 'academicSession', 'term', 'payments.student']);
        return view('fees.show', compact('fee'));
    }
}
