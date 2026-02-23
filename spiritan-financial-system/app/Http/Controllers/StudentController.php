<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['schoolClass', 'academicSession'])->latest()->paginate(20);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $classes = SchoolClass::where('is_active', true)->orderBy('name')->get();
        $sessions = AcademicSession::orderByDesc('starts_at')->get();
        return view('students.create', compact('classes', 'sessions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admission_number' => ['required', 'string', 'max:50', 'unique:students,admission_number'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'other_name' => ['nullable', 'string', 'max:100'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'academic_session_id' => ['nullable', 'exists:academic_sessions,id'],
            'parent_name' => ['required', 'string', 'max:150'],
            'parent_phone' => ['required', 'string', 'max:25'],
            'parent_email' => ['nullable', 'email'],
            'status' => ['required', 'in:active,inactive,graduated'],
        ]);

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['schoolClass', 'academicSession', 'payments.fee']);
        return view('students.show', compact('student'));
    }
}
