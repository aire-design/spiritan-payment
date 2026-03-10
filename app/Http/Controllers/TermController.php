<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::with('academicSession')->orderByDesc('created_at')->paginate(15);

        return view('admin.terms.index', compact('terms'));
    }

    public function create()
    {
        $sessions = AcademicSession::orderByDesc('name')->get();

        return view('admin.terms.create', compact('sessions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'name' => ['required', 'string', 'max:50'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_locked' => ['boolean'],
        ]);

        $data['is_locked'] = $request->has('is_locked');

        Term::create($data);

        return redirect()->route('terms.index')->with('success', 'Term created successfully.');
    }

    public function show(Term $term)
    {
        // View not typically needed for Terms, redirecting to edit
        return redirect()->route('terms.edit', $term);
    }

    public function edit(Term $term)
    {
        $sessions = AcademicSession::orderByDesc('name')->get();

        return view('admin.terms.edit', compact('term', 'sessions'));
    }

    public function update(Request $request, Term $term)
    {
        $data = $request->validate([
            'academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'name' => ['required', 'string', 'max:50'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_locked' => ['boolean'],
        ]);

        $data['is_locked'] = $request->has('is_locked');

        $term->update($data);

        return redirect()->route('terms.index')->with('success', 'Term updated successfully.');
    }

    public function destroy(Term $term)
    {
        $term->delete();

        return redirect()->route('terms.index')->with('success', 'Term deleted successfully.');
    }
}
