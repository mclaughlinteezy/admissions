@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Step 4: A-Level Subjects</h2>
    @if ($errors->has('alevel_subjects'))
        <div class="alert alert-danger">
            You must enter at least 2 A-Level subjects.
        </div>
    @endif


    <form method="POST" action="{{ route('student.application.step.post', 4) }}">
        @csrf

        <div id="alevel-subject-wrapper">
            @php
                $alevels = old('alevel_subjects', $application->alevel_subjects ?? []);
            @endphp

            @forelse ($alevels as $index => $subject)
                <div class="alevel-row row mb-3">
                    <div class="col-md-2">
                        <label>Exam Year:</label>
                        <input type="number" name="alevel_subjects[{{ $index }}][exam_year]" class="form-control"
                            value="{{ $subject['exam_year'] ?? '' }}" required>
                    </div>

                    <div class="col-md-3">
                        <label>Exam Board:</label>
                        <select name="alevel_subjects[{{ $index }}][exam_board]" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="ZIMSEC" {{ ($subject['exam_board'] ?? '') == 'ZIMSEC' ? 'selected' : '' }}>ZIMSEC</option>
                            <option value="Cambridge" {{ ($subject['exam_board'] ?? '') == 'Cambridge' ? 'selected' : '' }}>Cambridge</option>
                            <option value="Other" {{ ($subject['exam_board'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Subject Name:</label>
                        <input type="text" name="alevel_subjects[{{ $index }}][name]" class="form-control"
                            value="{{ $subject['name'] ?? '' }}" required>
                    </div>

                    <div class="col-md-2">
                        <label>Grade:</label>
                        <input type="text" name="alevel_subjects[{{ $index }}][grade]" class="form-control"
                            value="{{ $subject['grade'] ?? '' }}" required>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        @if ($loop->first)
                            <button type="button" class="btn btn-success btn-sm add-alevel">+</button>
                        @else
                            <button type="button" class="btn btn-danger btn-sm remove-alevel">−</button>
                        @endif
                    </div>
                </div>
            @empty
                {{-- If no subjects found, show one empty row --}}
                <div class="alevel-row row mb-3">
                    <div class="col-md-2">
                        <input type="number" name="alevel_subjects[0][exam_year]" class="form-control" placeholder="Year" required>
                    </div>
                    <div class="col-md-3">
                        <select name="alevel_subjects[0][exam_board]" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="ZIMSEC">ZIMSEC</option>
                            <option value="Cambridge">Cambridge</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="alevel_subjects[0][name]" class="form-control" placeholder="Subject" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="alevel_subjects[0][grade]" class="form-control" placeholder="Grade" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-success btn-sm add-alevel">+</button>
                    </div>
                </div>
            @endforelse
        </div>

        <a href="{{ route('student.application.step', 3) }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
</div>

@push('scripts')
<script>
    let alevelIndex = {{ count($alevels) ?: 1 }};

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-alevel')) {
            const wrapper = document.getElementById('alevel-subject-wrapper');
            const row = document.createElement('div');
            row.className = 'alevel-row row mb-3';

            row.innerHTML = `
                <div class="col-md-2">
                    <input type="number" name="alevel_subjects[${alevelIndex}][exam_year]" class="form-control" placeholder="Year" required>
                </div>
                <div class="col-md-3">
                    <select name="alevel_subjects[${alevelIndex}][exam_board]" class="form-control" required>
                        <option value="">-- Select --</option>
                        <option value="ZIMSEC">ZIMSEC</option>
                        <option value="Cambridge">Cambridge</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="alevel_subjects[${alevelIndex}][name]" class="form-control" placeholder="Subject" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="alevel_subjects[${alevelIndex}][grade]" class="form-control" placeholder="Grade" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-alevel">−</button>
                </div>
            `;

            wrapper.appendChild(row);
            alevelIndex++;
        }

        if (e.target.classList.contains('remove-alevel')) {
            e.target.closest('.alevel-row').remove();
        }
    });
</script>
@endpush
@endsection
