@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Step 5: Tertiary Education (OPTIONAL)</h2>

    <form method="POST" action="{{ route('student.application.step.post', 5) }}">
        @csrf

        <div id="tertiary-wrapper">
            @php
                $tertiaryRows = old('tertiary_education', $application->tertiary_education ?? [['year'=>'', 'institution'=>'', 'programme'=>'', 'programme_type'=>'', 'grade'=>'']]);
            @endphp

            @foreach ($tertiaryRows as $index => $row)
            <div class="tertiary-row row mb-3">
                <div class="col-md-2">
                    <label>Year:</label>
                    <input type="number" name="tertiary_education[{{ $index }}][year]" class="form-control" value="{{ $row['year'] ?? '' }}" placeholder="Year">
                </div>

                <div class="col-md-3">
                    <label>Institution:</label>
                    <input type="text" name="tertiary_education[{{ $index }}][institution]" class="form-control" value="{{ $row['institution'] ?? '' }}" placeholder="Institution">
                </div>

                <div class="col-md-3">
                    <label>Programme:</label>
                    <input type="text" name="tertiary_education[{{ $index }}][programme]" class="form-control" value="{{ $row['programme'] ?? '' }}" placeholder="Programme">
                </div>

                <div class="col-md-3">
                    <label>Programme Type:</label>
                    <select name="tertiary_education[{{ $index }}][programme_type]" class="form-control">
                        <option value="">-- Select Programme Type --</option>
                        <option value="NC" {{ ($row['programme_type'] ?? '') == 'NC' ? 'selected' : '' }}>National Certificate (NC)</option>
                        <option value="ND" {{ ($row['programme_type'] ?? '') == 'ND' ? 'selected' : '' }}>National Diploma (ND)</option>
                        <option value="HND" {{ ($row['programme_type'] ?? '') == 'HND' ? 'selected' : '' }}>Higher National Diploma (HND)</option>
                        <option value="Short Course" {{ ($row['programme_type'] ?? '') == 'Short Course' ? 'selected' : '' }}>Short Courses</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <label>Grade:</label>
                    <input type="text" name="tertiary_education[{{ $index }}][grade]" class="form-control" value="{{ $row['grade'] ?? '' }}" placeholder="Grade">
                </div>

                <div class="col-md-12 mt-2">
                    @if ($loop->last)
                        <button type="button" class="btn btn-success btn-sm add-tertiary">Add</button>
                    @else
                        <button type="button" class="btn btn-danger btn-sm remove-tertiary">Remove</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <a href="{{ route('student.application.step', 4) }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
</div>

@push('scripts')
<script>
    let tertiaryIndex = {{ count($tertiaryRows) }};

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-tertiary')) {
            const wrapper = document.getElementById('tertiary-wrapper');
            const row = document.createElement('div');
            row.className = 'tertiary-row row mb-3';

            row.innerHTML = `
                <div class="col-md-2">
                    <input type="number" name="tertiary_education[${tertiaryIndex}][year]" class="form-control" placeholder="Year">
                </div>
                <div class="col-md-3">
                    <input type="text" name="tertiary_education[${tertiaryIndex}][institution]" class="form-control" placeholder="Institution">
                </div>
                <div class="col-md-3">
                    <input type="text" name="tertiary_education[${tertiaryIndex}][programme]" class="form-control" placeholder="Programme">
                </div>
                <div class="col-md-3">
                    <select name="tertiary_education[${tertiaryIndex}][programme_type]" class="form-control">
                        <option value="">-- Select Programme Type --</option>
                        <option value="NC">National Certificate (NC)</option>
                        <option value="ND">National Diploma (ND)</option>
                        <option value="HND">Higher National Diploma (HND)</option>
                        <option value="Short Course">Short Courses</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <input type="text" name="tertiary_education[${tertiaryIndex}][grade]" class="form-control" placeholder="Grade">
                </div>
                <div class="col-md-12 mt-2">
                    <button type="button" class="btn btn-danger btn-sm remove-tertiary">Remove</button>
                </div>
            `;

            wrapper.appendChild(row);
            tertiaryIndex++;
        }

        if (e.target.classList.contains('remove-tertiary')) {
            e.target.closest('.tertiary-row').remove();
        }
    });
</script>
@endpush

@endsection
