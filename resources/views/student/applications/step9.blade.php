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
    <div class="card mb-3">
        <div class="card-header">Programmes Applied</div>
        <div class="card-body">
            <ol>
                @foreach($application->program_choice as $programme)
                    <li>{{ $programme }}</li>
                @endforeach
            </ol>
        </div>
    </div>

    {{-- O-Level --}}
    <div class="card mb-3">
        <div class="card-header">O Level Details</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr><th>Exam Board (Year)</th><th>Subject (Grade)</th></tr>
                </thead>
                <tbody>
                    @foreach($application->olevel_subjects as $subject)
                        <tr>
                            <td>{{ $subject['exam_board'] }} ({{ $subject['exam_year'] }})</td>
                            <td>{{ $subject['name'] }} ({{ $subject['grade'] }})</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- A-Level --}}
    <div class="card mb-3">
        <div class="card-header">A Level Details</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr><th>Exam Board (Year)</th><th>Subject (Grade)</th></tr>
                </thead>
                <tbody>
                    @foreach($application->alevel_subjects as $subject)
                        <tr>
                            <td>{{ $subject['exam_board'] }} ({{ $subject['exam_year'] }})</td>
                            <td>{{ $subject['name'] }} ({{ $subject['grade'] }})</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tertiary Education (optional) --}}
    @if(!empty($application->tertiary_education))
    <div class="card mb-3">
        <div class="card-header">Tertiary Education</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead><tr><th>Year</th><th>Institution</th><th>Programme</th><th>Type</th><th>Grade</th></tr></thead>
                <tbody>
                    @foreach($application->tertiary_education as $tertiary)
                        <tr>
                            <td>{{ $tertiary['year'] }}</td>
                            <td>{{ $tertiary['institution'] }}</td>
                            <td>{{ $tertiary['programme'] }}</td>
                            <td>{{ $tertiary['programme_type'] }}</td>
                            <td>{{ $tertiary['grade'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Work Experience (optional) --}}
    @if(!empty($application->work_experience))
    <div class="card mb-3">
        <div class="card-header">Work Experience</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead><tr><th>Company</th><th>Job Title</th><th>From</th><th>To</th></tr></thead>
                <tbody>
                    @foreach($application->work_experience as $exp)
                        <tr>
                            <td>{{ $exp['companyname'] }}</td>
                            <td>{{ $exp['jobtitle'] }}</td>
                            <td>{{ $exp['from_month'] }}/{{ $exp['from_year'] }}</td>
                            <td>{{ $exp['to_month'] ?? 'Current' }}/{{ $exp['to_year'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Referees (optional) --}}
    @if(!empty($application->referees))
    <div class="card mb-3">
        <div class="card-header">Referees</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Position</th></tr></thead>
                <tbody>
                    
                    @foreach($application->referees as $ref)
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
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Filename</th>
                </tr>
            </thead>
            <tbody>
                @foreach($application->documents as $doc)
                    <tr>
                        <td>{{ $doc->type }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                {{ basename($doc->file_path) }}
                            </a>
                        </td>
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

    <div class="text-end">
        <a href="{{ route('student.application.step.post', 8) }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('student.application.step.post', 10) }}" class="btn btn-primary">Proceed to Payment</a>
    </div>
</div>
@endsection
