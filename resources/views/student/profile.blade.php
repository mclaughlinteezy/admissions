@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
<div class="container">
    <h2 class="mb-4">Applicant Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-4">
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $applicant->title ?? '') }}" maxlength="10" placeholder="Mr, Ms, Dr, etc.">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <label for="surname" class="col-sm-2 col-form-label">Surname <span class="text-danger">*</span></label>
            <div class="col-sm-4">
                <input type="text" name="surname" id="surname" class="form-control @error('surname') is-invalid @enderror"
                    value="{{ old('surname', $applicant->surname ?? '') }}" maxlength="100" required>
                @error('surname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="first_names" class="col-sm-2 col-form-label">First Names <span class="text-danger">*</span></label>
            <div class="col-sm-4">
                <input type="text" name="first_names" id="first_names" class="form-control @error('first_names') is-invalid @enderror"
                    value="{{ old('first_names', $applicant->first_names ?? '') }}" maxlength="100" required>
                @error('first_names')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <label for="gender" class="col-sm-2 col-form-label">Gender <span class="text-danger">*</span></label>
            <div class="col-sm-4">
                <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                    <option value="">Select Gender</option>
                    @foreach(['Male', 'Female', 'Other'] as $gender)
                        <option value="{{ $gender }}" {{ old('gender', $applicant->gender ?? '') === $gender ? 'selected' : '' }}>
                            {{ $gender }}
                        </option>
                    @endforeach
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="national_id" class="col-sm-2 col-form-label">National ID</label>
            <div class="col-sm-4">
                <input type="text" name="national_id" id="national_id" class="form-control @error('national_id') is-invalid @enderror"
                    value="{{ old('national_id', $applicant->national_id ?? '') }}" maxlength="50">
                @error('national_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <label for="dob" class="col-sm-2 col-form-label">Date of Birth <span class="text-danger">*</span></label>
            <div class="col-sm-4">
                <input type="date" name="dob" id="dob" class="form-control @error('dob') is-invalid @enderror"
                    value="{{ old('dob', isset($applicant->dob) ? $applicant->dob->format('Y-m-d') : '') }}" required>
                @error('dob')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="place_of_birth" class="col-sm-2 col-form-label">Place of Birth</label>
            <div class="col-sm-4">
                <input type="text" name="place_of_birth" id="place_of_birth" class="form-control @error('place_of_birth') is-invalid @enderror"
                    value="{{ old('place_of_birth', $applicant->place_of_birth ?? '') }}" maxlength="100">
                @error('place_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <label for="marital_status" class="col-sm-2 col-form-label">Marital Status</label>
            <div class="col-sm-4">
                <select name="marital_status" id="marital_status" class="form-select @error('marital_status') is-invalid @enderror">
                    <option value="">Select Marital Status</option>
                    @foreach(['Single', 'Married', 'Divorced', 'Widowed'] as $status)
                        <option value="{{ $status }}" {{ old('marital_status', $applicant->marital_status ?? '') === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('marital_status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="country_id" class="col-sm-2 col-form-label">Country</label>
            <div class="col-sm-4">
                <select name="country_id" id="country_id" class="form-select @error('country_id') is-invalid @enderror">
                    <option value="">Select Country</option>
                    @foreach(App\Models\Country::all() as $country)
                        <option value="{{ $country->id }}" {{ old('country_id', $applicant->country_id ?? '') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
            <div class="col-sm-4">
                <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                    value="{{ old('phone_number', $applicant->phone_number ?? '') }}" maxlength="20">
                @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="address" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
                <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $applicant->address ?? '') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="citizenship" class="col-sm-2 col-form-label">Citizenship</label>
            <div class="col-sm-4">
                <input type="text" name="citizenship" id="citizenship" class="form-control @error('citizenship') is-invalid @enderror"
                    value="{{ old('citizenship', $applicant->citizenship ?? '') }}" maxlength="100">
                @error('citizenship')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <label for="applicant_type" class="col-sm-2 col-form-label">Applicant Type</label>
            <div class="col-sm-4">
                <select name="applicant_type" id="applicant_type" class="form-select @error('applicant_type') is-invalid @enderror">
                    <option value="">Select Type</option>
                    @foreach(['National', 'International'] as $type)
                        <option value="{{ $type }}" {{ old('applicant_type', $applicant->applicant_type ?? '') === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
                @error('applicant_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-4">
            <label for="application_mode" class="col-sm-2 col-form-label">Application Mode</label>
            <div class="col-sm-4">
                <select name="application_mode" id="application_mode" class="form-select @error('application_mode') is-invalid @enderror">
                    <option value="">Select Mode</option>
                    @foreach(['Manual', 'Online'] as $mode)
                        <option value="{{ $mode }}" {{ old('application_mode', $applicant->application_mode ?? '') === $mode ? 'selected' : '' }}>
                            {{ $mode }}
                        </option>
                    @endforeach
                </select>
                @error('application_mode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Profile</button>
    </form>
</div>
@endsection
