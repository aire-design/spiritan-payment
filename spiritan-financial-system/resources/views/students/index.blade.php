@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Students</h3>
        <a class="btn btn-spiritan" href="{{ route('students.create') }}">Add Student</a>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>Admission No</th>
                <th>Name</th>
                <th>Class</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->admission_number }}</td>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->schoolClass?->name }}</td>
                    <td>{{ $student->parent_name }}</td>
                    <td>{{ strtoupper($student->status) }}</td>
                    <td><a class="btn btn-outline-primary btn-sm" href="{{ route('students.show', $student) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="6">No students found.</td></tr>
            @endforelse
            </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $students->links() }}</div>
    </div>
@endsection
