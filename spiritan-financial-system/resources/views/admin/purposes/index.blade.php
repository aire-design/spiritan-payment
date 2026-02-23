@extends('layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="h3 text-spiritan">Payment Purposes</h2>
    </div>
    <div class="col-auto">
        <a href="{{ route('purposes.create') }}" class="btn btn-spiritan">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg me-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/></svg>
            Add New Purpose
        </a>
    </div>
</div>

<div class="card md-card border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purposes as $purpose)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $purpose->name }}</td>
                            <td class="text-secondary text-truncate" style="max-width: 300px;">{{ $purpose->description ?? 'N/A' }}</td>
                            <td>
                                @if($purpose->is_active)
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('purposes.edit', $purpose) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Edit</a>
                                <form action="{{ route('purposes.destroy', $purpose) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this payment purpose?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 ms-1">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <div class="mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-inboxes" viewBox="0 0 16 16"><path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438L14.933 6zM3.809 3.5a.5.5 0 0 1 .498-.4h7.386a.5.5 0 0 1 .498.4l1.241 2H2.568l1.241-2z"/><path d="M4.98 11a.5.5 0 0 0-.39.188L1.54 15H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 15h4.46l-3.05-3.812A.5.5 0 0 0 11.02 11H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .498.438h12.234a.5.5 0 0 0 .496-.438L14.933 16zM3.809 13.5a.5.5 0 0 1 .498-.4h7.386a.5.5 0 0 1 .498.4l1.241 2H2.568l1.241-2z"/></svg>
                                </div>
                                <p class="mb-0">No payment purposes found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
