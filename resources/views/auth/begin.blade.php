@extends('layouts.app')

@section('title', 'Begin Registration')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Begin Registration</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register.begin.post') }}">
                        @csrf
                        
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <select class="form-select @error('title') is-invalid @enderror" 
                                    id="title" name="title" required>
                                <option value="" disabled selected>Select Title</option>
                                <option value="Mr" {{ old('title') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                <option value="Ms" {{ old('title') == 'Ms' ? 'selected' : '' }}>Ms</option>
                                <option value="Mrs" {{ old('title') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                            </select>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" class="form-control @error('surname') is-invalid @enderror" 
                                   id="surname" name="surname" value="{{ old('surname') }}" required>
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select @error('gender') is-invalid @enderror" 
                                    id="gender" name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @php
                            $maxDate = \Carbon\Carbon::today()->subYears(16)->format('Y-m-d');
                        @endphp

                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                id="date_of_birth" name="date_of_birth" max="{{ $maxDate }}"
                                value="{{ old('date_of_birth') }}" required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nationality" class="form-label">Nationality</label>
                            <select class="form-select @error('nationality') is-invalid @enderror" 
                                    id="nationality" name="nationality" required>
                                <option value="" disabled selected>Select Nationality</option>
                                <option value="Zimbabwean" {{ old('nationality') == 'Zimbabwean' ? 'selected' : '' }}>Zimbabwean</option>
                                <option value="Other" {{ old('nationality') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('nationality')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_number" class="form-label">ID Number</label>
                            <input type="text" class="form-control @error('id_number') is-invalid @enderror"
                                id="id_number" name="id_number"
                                pattern="\d{2}-\d{6,7}-[A-Z]-\d{2}"
                                title="Format: 00-000000-A-00"
                                value="{{ old('id_number') }}" required>
                            <small class="form-text text-muted">Format: 00-000000-A-00 (e.g. 12-345678-A-01)</small>
                            @error('id_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="referral_source" class="form-label">How did you know about us?</label>
                            <select class="form-select @error('referral_source') is-invalid @enderror" 
                                    id="referral_source" name="referral_source" required>
                                <option value="" disabled selected>Select an option</option>
                                <option value="Friend or Family" {{ old('referral_source') == 'Friend or Family' ? 'selected' : '' }}>Friend or Family</option>
                                <option value="Social Media" {{ old('referral_source') == 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                <option value="Newspaper" {{ old('referral_source') == 'Newspaper' ? 'selected' : '' }}>Newspaper</option>
                                <option value="Radio or TV" {{ old('referral_source') == 'Radio or TV' ? 'selected' : '' }}>Radio or TV</option>
                                <option value="School Visit" {{ old('referral_source') == 'School Visit' ? 'selected' : '' }}>School Visit</option>
                                <option value="Website" {{ old('referral_source') == 'Website' ? 'selected' : '' }}>Website</option>
                                <option value="Other" {{ old('referral_source') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('referral_source')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow rounded-pill" id="submitBtn">
                                <span id="btnText"><i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Continue</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>

                    </form>

                    <hr>
                    <div class="text-center">
                        <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitBtn').addEventListener('click', function () {
        document.getElementById('btnText').classList.add('d-none');
        document.getElementById('btnSpinner').classList.remove('d-none');
    });
</script>
@endsection