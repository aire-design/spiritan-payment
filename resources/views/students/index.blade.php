@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
        <h3 class="text-spiritan mb-0 fw-bold" style="font-family:'Outfit';">Students</h3>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-success rounded-pill px-4 shadow-sm fw-semibold"
               href="{{ route('students.import.form') }}">
                <i class="bi bi-cloud-upload me-1"></i> Bulk Import
            </a>
            <a class="btn btn-md-primary rounded-pill px-4 shadow-sm fw-semibold"
               href="{{ route('students.create') }}">
                <i class="bi bi-plus-lg me-1"></i> Add Student
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:14px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="ps-4">Admission No</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($students as $student)
                    <tr>
                        <td class="ps-4 fw-medium text-muted small">{{ $student->admission_number }}</td>
                        <td class="fw-semibold">{{ $student->full_name }}</td>
                        <td>{{ $student->schoolClass?->name }}</td>
                        <td>{{ $student->parent_name }}</td>
                        <td>
                            @php $s = $student->status @endphp
                            <span class="badge rounded-pill px-3 py-1
                                {{ $s === 'active' ? 'bg-success' : ($s === 'graduated' ? 'bg-primary' : 'bg-secondary') }}">
                                {{ ucfirst($s) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a class="btn btn-primary btn-sm rounded-pill px-3 fw-medium shadow-sm"
                               href="{{ route('students.show', $student) }}">
                               <i class="bi bi-eye me-1"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-person-x fs-1 d-block mb-2 opacity-50"></i>
                            No students found.
                            <div class="mt-3 d-flex justify-content-center gap-2">
                                <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm rounded-pill px-4">Add One Manually</a>
                                <a href="{{ route('students.import.form') }}" class="btn btn-success btn-sm rounded-pill px-4">Bulk Import</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
                </table>
            </div>
        </div>
        @if($students->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $students->links() }}
            </div>
        @endif
    </div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
