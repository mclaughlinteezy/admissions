@extends('layouts.app')

@section('title', 'My Application')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-alt me-2"></i>My Application</h2>

    @if($application)
        <span class="badge bg-{{ $application->status_color }} status-badge fs-6">
            {{ ucfirst($application->status) }}
        </span>
    @endif
</div>

@if($application)
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Update Status</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.update-application-status', $application) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4" 
                                  placeholder="Add notes for the applicant...">{{ $application->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        {{-- Personal Information --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3"><strong>Full Name:</strong><br>{{ $application->first_name }} {{ $application->last_name }}</div>
                    <div class="col-md-6 mb-3"><strong>Date of Birth:</strong><br>{{ $application->date_of_birth->format('M d, Y') }}</div>
                    <div class="col-md-6 mb-3"><strong>Gender:</strong><br>{{ ucfirst($application->gender) }}</div>
                    <div class="col-md-6 mb-3"><strong>Phone:</strong><br>{{ $application->phone }}</div>
                    <div class="col-md-6 mb-3"><strong>Nationality:</strong><br>{{ $application->nationality }}</div>
                    <div class="col-12 mb-3"><strong>Address:</strong><br>{{ $application->address }}</div>
                </div>
            </div>
        </div>

        {{-- Academic Info --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Academic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3"><strong>Program Choice:</strong><br>{{ $application->program_choice }}</div>
                    <div class="col-md-6 mb-3"><strong>Academic Qualification:</strong><br>{{ $application->academic_qualification }}</div>
                    <div class="col-md-6 mb-3"><strong>GPA:</strong><br>{{ $application->gpa ?? 'Not provided' }}</div>
                    <div class="col-md-6 mb-3"><strong>Graduation Year:</strong><br>{{ $application->graduation_year }}</div>
                    <div class="col-12 mb-3"><strong>Previous School:</strong><br>{{ $application->previous_school }}</div>
                </div>
            </div>
        </div>

        {{-- Optional Statements --}}
        @if($application->personal_statement)
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-quote-left me-2"></i>Personal Statement</h5></div>
            <div class="card-body"><p>{{ $application->personal_statement }}</p></div>
        </div>
        @endif

        @if($application->admin_notes)
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-comment-alt me-2"></i>Admin Notes</h5></div>
            <div class="card-body">
                <div class="alert alert-info">{{ $application->admin_notes }}</div>
            </div>
        </div>
        @endif

        {{-- Details --}}
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Application Details</h5></div>
            <div class="card-body">
                <p><strong>Application ID:</strong><br>#{{ str_pad($application->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Submitted:</strong><br>{{ $application->submitted_at->format('M d, Y \a\t g:i A') }}</p>
                <p><strong>Status:</strong><br>
                    <span class="badge bg-{{ $application->status_color }}">{{ ucfirst($application->status) }}</span>
                </p>

                @if($application->document_path)
                <hr>
                <p><strong>Supporting Document:</strong></p>
                <a href="{{ asset('storage/' . $application->document_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-download me-2"></i>Download Document
                </a>
                @endif

                <hr>
                <a href="{{ route('student.dashboard') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@else
{{-- No application available --}}
<div class="alert alert-warning text-center">
    <h5 class="mb-2"><i class="fas fa-exclamation-circle me-2"></i>No Application Found</h5>
    <p>This user has not submitted an application yet.</p>
</div>
@endif
@endsection
