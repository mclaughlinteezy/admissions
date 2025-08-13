@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Step 3: O-Level Subjects</h2>
    @if ($errors->has('olevel_subjects'))
        <div class="alert alert-danger">
            You must enter at least 5 O-Level subjects.
        </div>
    @endif


    <form method="POST" action="{{ route('student.application.step.post', 3) }}">
        @csrf

        <div id="olevel-subject-wrapper">
            @php
                $olevels = old('olevel_subjects', $application->olevel_subjects ?? []);
            @endphp

            @forelse ($olevels as $index => $subject)
                <div class="olevel-row row mb-3">
                    <div class="col-md-2">
                        <label>Exam Year:</label>
                        <input type="number" name="olevel_subjects[{{ $index }}][exam_year]" class="form-control"
                            value="{{ $subject['exam_year'] ?? '' }}" required>
                    </div>

                    <div class="col-md-3">
                        <label>Exam Board:</label>
                        <select name="olevel_subjects[{{ $index }}][exam_board]" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="ZIMSEC" {{ ($subject['exam_board'] ?? '') == 'ZIMSEC' ? 'selected' : '' }}>ZIMSEC</option>
                            <option value="Cambridge" {{ ($subject['exam_board'] ?? '') == 'Cambridge' ? 'selected' : '' }}>Cambridge</option>
                            <option value="Other" {{ ($subject['exam_board'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Subject Name:</label>
                        <input type="text" name="olevel_subjects[{{ $index }}][name]" class="form-control"
                            value="{{ $subject['name'] ?? '' }}" required>
                    </div>

                    <div class="col-md-2">
                        <label>Grade:</label>
                        <input type="text" name="olevel_subjects[{{ $index }}][grade]" class="form-control"
                            value="{{ $subject['grade'] ?? '' }}" required>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        @if ($loop->first)
                            <button type="button" class="btn btn-success btn-sm add-olevel">+</button>
                        @else
                            <button type="button" class="btn btn-danger btn-sm remove-olevel">−</button>
                        @endif
                    </div>
                </div>
            @empty
                {{-- If no subjects found, show one empty row --}}
                <div class="olevel-row row mb-3">
                    <div class="col-md-2">
                        <input type="number" name="olevel_subjects[0][exam_year]" class="form-control" placeholder="Year" required>
                    </div>
                    <div class="col-md-3">
                        <select name="olevel_subjects[0][exam_board]" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="ZIMSEC">ZIMSEC</option>
                            <option value="Cambridge">Cambridge</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="olevel_subjects[0][name]" class="form-control" placeholder="Subject" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="olevel_subjects[0][grade]" class="form-control" placeholder="Grade" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-success btn-sm add-olevel">+</button>
                    </div>
                </div>
            @endforelse
        </div>

        <a href="{{ route('student.application.step', 2) }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
</div>

@push('scripts')
<script>
    let olevelIndex = {{ count($olevels) ?: 1 }};

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-olevel')) {
            const wrapper = document.getElementById('olevel-subject-wrapper');
            const row = document.createElement('div');
            row.className = 'olevel-row row mb-3';

            row.innerHTML = `
                <div class="col-md-2">
                    <input type="number" name="olevel_subjects[${olevelIndex}][exam_year]" class="form-control" placeholder="Year" required>
                </div>
                <div class="col-md-3">
                    <select name="olevel_subjects[${olevelIndex}][exam_board]" class="form-control" required>
                        <option value="">-- Select --</option>
                        <option value="ZIMSEC">ZIMSEC</option>
                        <option value="Cambridge">Cambridge</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="olevel_subjects[${olevelIndex}][name]" class="form-control" placeholder="Subject" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="olevel_subjects[${olevelIndex}][grade]" class="form-control" placeholder="Grade" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-olevel">−</button>
                </div>
            `;

            wrapper.appendChild(row);
            olevelIndex++;
        }

        if (e.target.classList.contains('remove-olevel')) {
            e.target.closest('.olevel-row').remove();
        }
    });
</script>
@endpush
@endsection
