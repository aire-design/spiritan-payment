@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-spiritan mb-0">Terms Dashboard</h3>
        <a href="{{ route('terms.create') }}" class="btn btn-spiritan">Add New Term</a>
    </div>

    <div class="card p-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Term Name</th>
                        <th>Academic Session</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Locked</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($terms as $term)
                        <tr>
                            <td class="fw-medium">{{ $term->name }}</td>
                            <td>{{ $term->academicSession?->name }}</td>
                            <td>{{ $term->starts_at ? \Carbon\Carbon::parse($term->starts_at)->format('d M Y') : 'N/A' }}</td>
                            <td>{{ $term->ends_at ? \Carbon\Carbon::parse($term->ends_at)->format('d M Y') : 'N/A' }}</td>
                            <td>
                                @if($term->is_locked)
                                    <span class="badge bg-danger rounded-pill">Locked</span>
                                @else
                                    <span class="badge bg-success rounded-pill">Active</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('terms.edit', $term) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('terms.destroy', $term) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this term?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No terms created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $terms->links() }}
        </div>
    </div>
@endsection
