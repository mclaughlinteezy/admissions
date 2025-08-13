@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Step 2: Select Programme</h2>

    <form method="POST" action="{{ route('student.application.step.post', 2) }}">
        @csrf
        @php
            // No DB: default empty choices
            $choices = [];
        @endphp

        <div class="form-group">
            <label for="programme_first">First Programme:</label>
            <select name="programme_first" id="programme_first" class="form-control" required>
                <option value="">-- Select Programme --</option>
                <option value="computer_science" {{ old('programme_first', $choices[0] ?? '') == 'computer_science' ? 'selected' : '' }}>Computer Science</option>
                <option value="business_admin" {{ old('programme_first', $choices[0] ?? '') == 'business_admin' ? 'selected' : '' }}>Business Administration</option>
                <option value="engineering" {{ old('programme_first', $choices[0] ?? '') == 'engineering' ? 'selected' : '' }}>Engineering</option>
            </select>

            <label for="programme_second" class="mt-3">Second Programme:</label>
            <select name="programme_second" id="programme_second" class="form-control" required>
                <option value="">-- Select Programme --</option>
                <option value="computer_science" {{ old('programme_second', $choices[1] ?? '') == 'computer_science' ? 'selected' : '' }}>Computer Science</option>
                <option value="business_admin" {{ old('programme_second', $choices[1] ?? '') == 'business_admin' ? 'selected' : '' }}>Business Administration</option>
                <option value="engineering" {{ old('programme_second', $choices[1] ?? '') == 'engineering' ? 'selected' : '' }}>Engineering</option>
            </select>

            <label for="programme_third" class="mt-3">Third Programme:</label>
            <select name="programme_third" id="programme_third" class="form-control" required>
                <option value="">-- Select Programme --</option>
                <option value="computer_science" {{ old('programme_third', $choices[2] ?? '') == 'computer_science' ? 'selected' : '' }}>Computer Science</option>
                <option value="business_admin" {{ old('programme_third', $choices[2] ?? '') == 'business_admin' ? 'selected' : '' }}>Business Administration</option>
                <option value="engineering" {{ old('programme_third', $choices[2] ?? '') == 'engineering' ? 'selected' : '' }}>Engineering</option>
            </select>
        </div>

        <a href="{{ route('student.application.step', 1) }}" class="btn btn-secondary mt-4">Back</a>
        <button type="submit" class="btn btn-primary mt-4">Next</button>
    </form>
</div>
@endsection
