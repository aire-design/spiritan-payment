@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
    <div>
        <h2 class="h3 text-spiritan mb-1 fw-bold" style="font-family:'Outfit';">Bulk Import Students</h2>
        <p class="text-muted mb-0">Upload an Excel (.xlsx) or CSV file to add multiple students at once.</p>
    </div>
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-1"></i> Back to Students
    </a>
</div>

{{-- Skipped rows feedback --}}
@if(session('skipped_rows') && count(session('skipped_rows')) > 0)
<div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
    <strong><i class="bi bi-exclamation-triangle me-1"></i> Some rows were skipped:</strong>
    <ul class="mt-2 mb-0">
        @foreach(session('skipped_rows') as $row)
            <li>{{ $row }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    {{-- Instructions Card --}}
    <div class="col-lg-5">
        <div class="card border-0 h-100" style="border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.08);">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge rounded-circle p-2" style="background:#e8f0fe;">
                        <i class="bi bi-info-circle-fill text-primary fs-5"></i>
                    </span>
                    <h5 class="mb-0 fw-bold" style="font-family:'Outfit';">How It Works</h5>
                </div>

                <ol class="ps-3 mb-4" style="line-height:2;">
                    <li>Download the <strong>CSV template</strong> below.</li>
                    <li>Open it in Excel, Google Sheets, or LibreOffice.</li>
                    <li>Fill in student details — one student per row.</li>
                    <li>Save as <strong>.xlsx</strong> or <strong>.csv</strong>.</li>
                    <li>Upload the file using the form on this page.</li>
                </ol>

                <hr class="text-muted">

                <h6 class="fw-bold mb-3" style="font-family:'Outfit';">Column Reference</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle" style="font-size:0.85rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Column</th>
                                <th>Required?</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><code>admission_number</code></td><td><span class="badge bg-danger">Yes</span></td><td>Must be unique</td></tr>
                            <tr><td><code>first_name</code></td><td><span class="badge bg-danger">Yes</span></td><td>—</td></tr>
                            <tr><td><code>last_name</code></td><td><span class="badge bg-danger">Yes</span></td><td>—</td></tr>
                            <tr><td><code>other_name</code></td><td><span class="badge bg-secondary">No</span></td><td>Middle name</td></tr>
                            <tr><td><code>class</code></td><td><span class="badge bg-danger">Yes</span></td><td>Must match an existing class name exactly</td></tr>
                            <tr><td><code>parent_name</code></td><td><span class="badge bg-secondary">No</span></td><td>—</td></tr>
                            <tr><td><code>parent_phone</code></td><td><span class="badge bg-secondary">No</span></td><td>—</td></tr>
                            <tr><td><code>parent_email</code></td><td><span class="badge bg-secondary">No</span></td><td>Links to a parent account if email matches</td></tr>
                            <tr><td><code>status</code></td><td><span class="badge bg-secondary">No</span></td><td><code>active</code> / <code>inactive</code> / <code>graduated</code>. Defaults to <code>active</code></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info d-flex align-items-start gap-2 mt-3 mb-0 py-2 px-3" style="font-size:0.85rem; border-radius:10px;">
                    <i class="bi bi-lightbulb-fill text-warning mt-1"></i>
                    <span>If a student with the same <code>admission_number</code> already exists, their record will be <strong>updated</strong> — not duplicated.</span>
                </div>

                {{-- Available classes --}}
                <div class="mt-4">
                    <h6 class="fw-bold mb-2" style="font-family:'Outfit';">Active Classes in the System</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($classes as $class)
                            <span class="badge rounded-pill px-3 py-2" style="background:#e8f0fe; color:#0b3d91; font-size:0.82rem;">
                                {{ $class->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('students.import.template') }}"
                   class="btn btn-success rounded-pill px-4 mt-4 w-100 fw-semibold shadow-sm">
                    <i class="bi bi-download me-2"></i> Download CSV Template
                </a>
            </div>
        </div>
    </div>

    {{-- Upload Card --}}
    <div class="col-lg-7">
        <div class="card border-0 h-100" style="border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.08);">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="badge rounded-circle p-2" style="background:#e6f9f0;">
                        <i class="bi bi-cloud-upload-fill text-success fs-5"></i>
                    </span>
                    <h5 class="mb-0 fw-bold" style="font-family:'Outfit';">Upload Your File</h5>
                </div>

                <form method="POST" action="{{ route('students.import') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Drop zone --}}
                    <label for="fileInput" id="dropZone"
                        class="d-flex flex-column justify-content-center align-items-center w-100 mb-4 text-center"
                        style="border: 2.5px dashed #c7d4f5; border-radius:14px; background:#f5f7ff;
                               min-height:200px; cursor:pointer; transition:background 0.2s;">
                        <i class="bi bi-file-earmark-spreadsheet text-primary" style="font-size:3rem;"></i>
                        <span class="fw-semibold text-primary mt-2 fs-6">Click to browse</span>
                        <span class="text-muted small mt-1">or drag and drop here</span>
                        <span class="badge bg-secondary rounded-pill mt-3 px-3" id="fileLabel">
                            Accepts .xlsx, .xls, .csv — max 5 MB
                        </span>
                    </label>
                    <input type="file" id="fileInput" name="file" accept=".xlsx,.xls,.csv"
                           class="d-none @error('file') is-invalid @enderror"
                           onchange="updateLabel(this)">

                    @error('file')
                        <div class="invalid-feedback d-block mb-3">{{ $message }}</div>
                    @enderror

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-md-primary btn-lg rounded-pill fw-semibold shadow-sm py-3">
                            <i class="bi bi-upload me-2"></i> Import Students
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary rounded-pill">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateLabel(input) {
        const label = document.getElementById('fileLabel');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
            label.classList.remove('bg-secondary');
            label.classList.add('bg-success');
        }
    }

    // Drag-and-drop
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.style.background = '#e8f0fe';
    });
    dropZone.addEventListener('dragleave', () => {
        dropZone.style.background = '#f5f7ff';
    });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.style.background = '#f5f7ff';
        fileInput.files = e.dataTransfer.files;
        updateLabel(fileInput);
    });
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
