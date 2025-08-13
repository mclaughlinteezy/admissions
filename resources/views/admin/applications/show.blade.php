@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-alt me-2"></i>Application #{{ str_pad($application->id, 6, '0', STR_PAD_LEFT) }}</h2>
    <span class="badge bg-{{ $application->status_color }} fs-6">
        {{ ucfirst($application->status) }}
    </span>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Step 1 & 2: Attendance + Programme -->
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Study Details</h5></div>
            <div class="card-body">
                <p><strong>Attendance Mode:</strong> {{ $application->attendance_mode }}</p>
                <p><strong>Preferred Campus:</strong> {{ $application->preferred_campus }}</p>
                <p><strong>Intake:</strong> {{ $application->intake }}</p>
                <p><strong>Program Choice:</strong> {{ $application->program_choice }}</p>
            </div>
        </div>

        <!-- Step 3 & 4: O-Level and A-Level -->
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Academic Qualifications</h5></div>
            <div class="card-body">
                <strong>O-Level Subjects:</strong>
                <ul>
                    @foreach(json_decode($application->olevel_subjects, true) ?? [] as $subj)
                        <li>{{ $subj['name'] ?? '-' }} - Grade: {{ $subj['grade'] ?? '-' }}</li>
                    @endforeach
                </ul>

                <strong>A-Level Subjects:</strong>
                <ul>
                    @foreach(json_decode($application->alevel_subjects, true) ?? [] as $subj)
                        <li>{{ $subj['name'] ?? '-' }} - Grade: {{ $subj['grade'] ?? '-' }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Step 5: Tertiary Education -->
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Tertiary Education</h5></div>
            <div class="card-body">
                <p><strong>Institution:</strong> {{ $application->tertiary_institution ?? 'N/A' }}</p>
                <p><strong>Qualification:</strong> {{ $application->tertiary_qualification ?? 'N/A' }}</p>
                <p><strong>Year:</strong> {{ $application->tertiary_year ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Step 6: Work Experience -->
        @if($application->work_experience)
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Work Experience</h5></div>
            <div class="card-body">
                @php $exp = json_decode($application->work_experience, true); @endphp
                <p><strong>Employer:</strong> {{ $exp['employer'] ?? 'N/A' }}</p>
                <p><strong>Position:</strong> {{ $exp['position'] ?? 'N/A' }}</p>
                <p><strong>Duration:</strong> {{ $exp['duration'] ?? 'N/A' }}</p>
            </div>
        </div>
        @endif

        <!-- Step 7: Referee -->
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Referee Information</h5></div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $application->referee_name }}</p>
                <p><strong>Email:</strong> {{ $application->referee_email }}</p>
                <p><strong>Phone:</strong> {{ $application->referee_phone }}</p>
                <p><strong>Position:</strong> {{ $application->referee_position ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Step 10-11: Payment -->
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Payment</h5></div>
            <div class="card-body">
                <p><strong>Method:</strong> {{ $application->payment_method ?? 'N/A' }}</p>

                @if($application->proof_of_payment_path)
                    <p><strong>Proof of Payment:</strong><br>
                        <a href="{{ asset('storage/' . $application->proof_of_payment_path) }}" target="_blank" class="btn btn-sm btn-outline-success mt-2">
                            <i class="fas fa-download me-1"></i>Download File
                        </a>
                    </p>
                @else
                    <p class="text-muted">No payment proof uploaded.</p>
                @endif
            </div>
        </div>

        <!-- Admin Notes -->
        @if($application->admin_notes)
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Admin Notes</h5></div>
            <div class="card-body">
                <p>{{ $application->admin_notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column: Status -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-user me-2"></i>Applicant Info</h5></div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $application->first_name }} {{ $application->last_name }}</p>
                <p><strong>Email:</strong> {{ $application->user->email }}</p>
                <p><strong>DOB:</strong> {{ optional($application->date_of_birth)->format('M d, Y') }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($application->gender) }}</p>
                <p><strong>Phone:</strong> {{ $application->phone }}</p>
                <p><strong>Nationality:</strong> {{ $application->nationality }}</p>
                <p><strong>Address:</strong> {{ $application->address }}</p>
            </div>
        </div>

        <!-- Status & Dates -->
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Application Status</h5></div>
            <div class="card-body">
                <p>Status: <span class="badge bg-{{ $application->status_color }}">{{ ucfirst($application->status) }}</span></p>
                <p>Submitted: {{ optional($application->submitted_at)->format('M d, Y') }}</p>
                <p>Last Updated: {{ $application->updated_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
