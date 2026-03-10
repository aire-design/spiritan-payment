<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = AcademicSession::latest()->paginate(10);
        return view('admin.academic_sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.academic_sessions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:academic_sessions,name',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_locked' => 'boolean',
        ]);

        $data['is_locked'] = $request->has('is_locked');

        AcademicSession::create($data);

        return redirect()->route('academic-sessions.index')->with('success', 'Academic Session created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicSession $academicSession)
    {
        return view('admin.academic_sessions.edit', compact('academicSession'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicSession $academicSession)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:academic_sessions,name,' . $academicSession->id,
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_locked' => 'boolean',
        ]);

        $data['is_locked'] = $request->has('is_locked');

        $academicSession->update($data);

        return redirect()->route('academic-sessions.index')->with('success', 'Academic Session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicSession $academicSession)
    {
        if ($academicSession->terms()->exists() || $academicSession->students()->exists()) {
            return back()->with('error', 'Cannot delete session because it has associated terms or students.');
        }

        $academicSession->delete();

        return redirect()->route('academic-sessions.index')->with('success', 'Academic Session deleted successfully.');
    }
}
