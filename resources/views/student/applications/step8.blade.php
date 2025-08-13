@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Step 8: Upload Documents</h2>

    <form method="POST" action="{{ route('student.application.step.post', 8) }}" enctype="multipart/form-data">
        @csrf

        <div id="document-wrapper">
            @php
                // Get old input or from application documents for editing
                $oldDocs = old('document_types', []);
                $hasOld = count($oldDocs) > 0;
                $existingDocs = $application->documents ?? collect();
            @endphp

            @if($hasOld)
                @foreach ($oldDocs as $i => $type)
                <div class="document-row mb-3 row">
                    <div class="col-md-6">
                        <label>Document File (PDF, JPG, PNG):</label>
                        <input type="file" name="documents[]" class="form-control" {{ $i === 0 ? 'required' : '' }}>
                    </div>
                    <div class="col-md-4">
                        <label>Document Type:</label>
                        <select name="document_types[]" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="ID" {{ $type == 'ID' ? 'selected' : '' }}>ID</option>
                            <option value="Transcript" {{ $type == 'Transcript' ? 'selected' : '' }}>Transcript</option>
                            <option value="Certificate" {{ $type == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                            <option value="Other" {{ $type == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    @if($i > 0)
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-document">Remove</button>
                    </div>
                    @endif
                </div>
                @endforeach
            @elseif($existingDocs->count())
                @foreach ($existingDocs as $i => $doc)
                <div class="document-row mb-3 row">
                    <div class="col-md-6">
                        <label>Document File (PDF, JPG, PNG):</label>
                        <input type="file" name="documents[]" class="form-control">
                        <small class="form-text text-muted">Current file: <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">{{ basename($doc->file_path) }}</a></small>
                    </div>
                    <div class="col-md-4">
                        <label>Document Type:</label>
                        <select name="document_types[]" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="ID" {{ $doc->type == 'ID' ? 'selected' : '' }}>ID</option>
                            <option value="Transcript" {{ $doc->type == 'Transcript' ? 'selected' : '' }}>Transcript</option>
                            <option value="Certificate" {{ $doc->type == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                            <option value="Other" {{ $doc->type == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    @if($i > 0)
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-document">Remove</button>
                    </div>
                    @endif
                </div>
                @endforeach
            @else
                <div class="document-row mb-3 row">
                    <div class="col-md-6">
                        <label>Document File (PDF, JPG, PNG):</label>
                        <input type="file" name="documents[]" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Document Type:</label>
                        <select name="document_types[]" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="ID">ID</option>
                            <option value="Transcript">Transcript</option>
                            <option value="Certificate">Certificate</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            @endif
        </div>

        <button type="button" id="add-document-btn" class="btn btn-info mb-3">Add Another Document</button>

        <div>
            <a href="{{ route('student.application.step', 7) }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('document-wrapper');
        const addBtn = document.getElementById('add-document-btn');

        addBtn.addEventListener('click', function () {
            const row = document.createElement('div');
            row.classList.add('document-row', 'mb-3', 'row');
            row.innerHTML = `
                <div class="col-md-6">
                    <label>Document File (PDF, JPG, PNG):</label>
                    <input type="file" name="documents[]" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Document Type:</label>
                    <select name="document_types[]" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="ID">ID</option>
                        <option value="Transcript">Transcript</option>
                        <option value="Certificate">Certificate</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-document">Remove</button>
                </div>
            `;
            wrapper.appendChild(row);
        });

        wrapper.addEventListener('click', function(e) {
            if(e.target.classList.contains('remove-document')) {
                e.target.closest('.document-row').remove();
            }
        });
    });
</script>
@endpush

@endsection
