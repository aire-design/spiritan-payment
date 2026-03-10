<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Models\AcademicSession;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['schoolClass', 'academicSession'])->latest()->paginate(20);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $classes  = SchoolClass::where('is_active', true)->orderBy('name')->get();
        $sessions = AcademicSession::orderByDesc('starts_at')->get();

        return view('students.create', compact('classes', 'sessions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admission_number'   => ['required', 'string', 'max:50', 'unique:students,admission_number'],
            'first_name'         => ['required', 'string', 'max:100'],
            'last_name'          => ['required', 'string', 'max:100'],
            'other_name'         => ['nullable', 'string', 'max:100'],
            'school_class_id'    => ['required', 'exists:school_classes,id'],
            'academic_session_id'=> ['nullable', 'exists:academic_sessions,id'],
            'parent_name'        => ['required', 'string', 'max:150'],
            'parent_phone'       => ['required', 'string', 'max:25'],
            'parent_email'       => ['nullable', 'email'],
            'status'             => ['required', 'in:active,inactive,graduated'],
        ]);

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['schoolClass', 'academicSession', 'payments.fee']);

        return view('students.show', compact('student'));
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Bulk Import
    // ──────────────────────────────────────────────────────────────────────────

    public function importForm()
    {
        $classes = SchoolClass::where('is_active', true)->orderBy('name')->get();
        return view('students.import', compact('classes'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        $import = new StudentsImport();
        Excel::import($import, $request->file('file'));

        $importedCount = count($import->importedRows);
        $skippedCount  = count($import->skippedRows);

        $message = "{$importedCount} student(s) imported successfully.";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} row(s) skipped.";
        }

        return redirect()
            ->route('students.import.form')
            ->with('success', $message)
            ->with('skipped_rows', $import->skippedRows);
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students_import_template.csv"',
        ];

        $columns = [
            'admission_number',
            'first_name',
            'last_name',
            'other_name',
            'class',
            'parent_name',
            'parent_phone',
            'parent_email',
            'status',
        ];

        $callback = function () use ($columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);
            // Example rows
            fputcsv($handle, ['SPT/2024/001', 'Jane', 'Doe', '', 'JSS 1', 'Mrs Doe', '08012345678', 'parent@example.com', 'active']);
            fputcsv($handle, ['SPT/2024/002', 'Mary', 'Smith', 'Grace', 'SSS 2', 'Mr Smith', '08087654321', '', 'active']);
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
