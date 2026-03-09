@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 text-spiritan mb-0">Academic Sessions</h2>
    <a href="{{ route('academic-sessions.create') }}" class="btn btn-md-primary rounded-pill px-4 shadow-sm fw-medium transition-all">Add New Session</a>
</div>

<div class="card md-card border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Name</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($sessions as $session)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $session->name }}</td>
                        <td class="text-secondary small">
                            {{ \Carbon\Carbon::parse($session->starts_at)->format('M d, Y') }} - 
                            {{ \Carbon\Carbon::parse($session->ends_at)->format('M d, Y') }}
                        </td>
                        <td>
                            @if($session->is_locked)
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1"><i class="bi bi-lock-fill me-1"></i>Locked</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1"><i class="bi bi-unlock-fill me-1"></i>Active</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('academic-sessions.edit', $session) }}" class="btn btn-sm btn-outline-primary rounded-circle me-2" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg>
                            </a>
                            <form action="{{ route('academic-sessions.destroy', $session) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this academic session?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <p class="mb-0">No academic sessions found.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($sessions->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
