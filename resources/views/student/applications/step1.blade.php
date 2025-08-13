@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Step 1: Attendance Mode</h2>

    <form method="POST" action="{{ route('student.application.step.post', 1) }}">
        @csrf

        <div class="form-group">
            <label for="attendance_mode">Attendance Mode:</label>
            <select name="attendance_mode" id="attendance_mode" class="form-control" required>
                <option value="">-- Select Attendance Mode --</option>
                <option value="Conventional" {{ old('attendance_mode') == 'Conventional' ? 'selected' : '' }}>Conventional</option>
                <option value="Block Release" {{ old('attendance_mode') == 'Block Release' ? 'selected' : '' }}>Block Release</option>
                <option value="Visiting" {{ old('attendance_mode') == 'Visiting' ? 'selected' : '' }}>Visiting</option>
            </select>
            @error('attendance_mode')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- <div class="form-group mt-3">
            <label for="preferred_campus">Preferred Campus:</label>
            <input type="text" name="preferred_campus" id="preferred_campus" class="form-control"
                value="{{ old('preferred_campus') }}" required>
            @error('preferred_campus')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="intake">Intake:</label>
            <input type="text" name="intake" id="intake" class="form-control"
                value="{{ old('intake') }}" required>
            @error('intake')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div> --}}

        <button type="submit" class="btn btn-primary mt-3">Next</button>
    </form>
</div>
@endsection
