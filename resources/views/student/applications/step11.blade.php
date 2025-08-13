@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Application Summary</h4>
        <div>
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">Print Summary</button>
            <a href="{{ route('student.application.export.pdf') }}" class="btn btn-sm btn-outline-primary">Download PDF</a>
        </div>
    </div>

    <p class="text-muted">Review your application below before finalizing.</p>

    {{-- Application Details --}}
    <div class="card mb-3">
        <div class="card-header">Application Details</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <tr><th>Reference Code</th><td>{{ $application->reference_code ?? 'N/A' }}</td></tr>
                <tr><th>Period</th><td>{{ $application->intake }}</td></tr>
                <tr><th>Status</th><td>{{ $application->submitted_at ? 'Submitted' : 'Not Completed' }}</td></tr>
                <tr><th>Application Type</th><td>{{ ucfirst($application->type ?? 'Undergraduate') }}</td></tr>
                <tr><th>Campus</th><td>{{ $application->preferred_campus }}</td></tr>
                <tr><th>Attendance Type</th><td>{{ $application->attendance_mode }}</td></tr>
            </table>
        </div>
    </div>

    {{-- Programmes --}}
    @php
        $programs = is_array($application->program_choice) 
                    ? $application->program_choice 
                    : json_decode($application->program_choice, true);
    @endphp
    <div class="card mb-3">
        <div class="card-header">Programmes Applied</div>
        <div class="card-body">
            @if(!empty($programs))
                <ol>
                    @foreach($programs as $programme)
                        <li>{{ $programme }}</li>
                    @endforeach
                </ol>
            @else
                <p class="text-muted">No programmes selected.</p>
            @endif
        </div>
    </div>

    {{-- O-Level --}}
    @php
        $olevels = is_array($application->olevel_subjects)
            ? $application->olevel_subjects
            : json_decode($application->olevel_subjects, true);
    @endphp
    <div class="card mb-3">
        <div class="card-header">O Level Details</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr><th>Exam Board (Year)</th><th>Subject (Grade)</th></tr>
                </thead>
                <tbody>
                    @foreach($olevels as $subject)
                        <tr>
                            <td>{{ $subject['exam_board'] ?? '-' }} ({{ $subject['exam_year'] ?? '-' }})</td>
                            <td>{{ $subject['name'] ?? '-' }} ({{ $subject['grade'] ?? '-' }})</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- A-Level --}}
    @php
        $alevels = is_array($application->alevel_subjects)
            ? $application->alevel_subjects
            : json_decode($application->alevel_subjects, true);
    @endphp
    <div class="card mb-3">
        <div class="card-header">A Level Details</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr><th>Exam Board (Year)</th><th>Subject (Grade)</th></tr>
                </thead>
                <tbody>
                    @foreach($alevels as $subject)
                        <tr>
                            <td>{{ $subject['exam_board'] ?? '-' }} ({{ $subject['exam_year'] ?? '-' }})</td>
                            <td>{{ $subject['name'] ?? '-' }} ({{ $subject['grade'] ?? '-' }})</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tertiary Education --}}
    @php
        $tertiary = is_array($application->tertiary_education)
            ? $application->tertiary_education
            : json_decode($application->tertiary_education, true);
    @endphp
    @if(!empty($tertiary))
    <div class="card mb-3">
        <div class="card-header">Tertiary Education</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr><th>Year</th><th>Institution</th><th>Programme</th><th>Type</th><th>Grade</th></tr>
                </thead>
                <tbody>
                    @foreach($tertiary as $row)
                        <tr>
                            <td>{{ $row['year'] }}</td>
                            <td>{{ $row['institution'] }}</td>
                            <td>{{ $row['programme'] }}</td>
                            <td>{{ $row['programme_type'] }}</td>
                            <td>{{ $row['grade'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Work Experience --}}
    @php
        $work = is_array($application->work_experience)
            ? $application->work_experience
            : json_decode($application->work_experience, true);
    @endphp
    @if(!empty($work))
    <div class="card mb-3">
        <div class="card-header">Work Experience</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead><tr><th>Company</th><th>Job Title</th><th>From</th><th>To</th></tr></thead>
                <tbody>
                    @foreach($work as $job)
                        <tr>
                            <td>{{ $job['companyname'] }}</td>
                            <td>{{ $job['jobtitle'] }}</td>
                            <td>{{ $job['from_month'] }}/{{ $job['from_year'] }}</td>
                            <td>{{ $job['to_month'] ?? 'Current' }}/{{ $job['to_year'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Referees --}}
    @php
        $referees = is_array($application->referees)
            ? $application->referees
            : json_decode($application->referees, true);
    @endphp
    @if(!empty($referees))
    <div class="card mb-3">
        <div class="card-header">Referees</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Position</th></tr></thead>
                <tbody>
                    @foreach($referees as $ref)
                        <tr>
                            <td>{{ $ref['referee_name'] }}</td>
                            <td>{{ $ref['referee_email'] }}</td>
                            <td>{{ $ref['referee_phone'] }}</td>
                            <td>{{ $ref['referee_position'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Uploaded Documents --}}
    <div class="card mb-3">
        <div class="card-header">Uploaded Documents</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead><tr><th>Type</th><th>Filename</th></tr></thead>
                <tbody>
                    @foreach($application->documents as $doc)
                        <tr>
                            <td>{{ $doc->type }}</td>
                            <td><a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">{{ basename($doc->file_path) }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Payment Info --}}
    <div class="card mb-4">
        <div class="card-header">Payment</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <tr>
                    <th>Method</th>
                    <td>{{ $application->payment_method ?? 'Upload' }}</td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td>
                        @php
                            $latestPayment = $application->payments->last(); // assumes hasMany relationship
                        @endphp

                        @if($latestPayment)
                            {{ ucfirst($latestPayment->status) }}
                        @else
                            Not Submitted
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Application Fee</th>
                    <td>
                        USD 10: 
                        @if($latestPayment && $latestPayment->status === 'approved')
                            <span class="text-success fw-bold">Paid</span>
                        @else
                            <span class="text-danger fw-bold">Not Paid</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

    </div>

    {{-- Admin Notes --}}
    @if($application->admin_notes)
        <div class="alert alert-info mt-3 mb-4" role="alert">
            <strong>Admin Notes:</strong> {{ $application->admin_notes }}
        </div>
    @endif

    <div class="text-end">
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">Home</a>
        @if(!$application->submitted_at)
            <form method="POST" action="{{ route('student.application.submit') }}" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-primary">Submit Application</button>
            </form>
        @else
            <span class="badge bg-success">Application Submitted</span>
        @endif
    </div>
</div>
@endsection
