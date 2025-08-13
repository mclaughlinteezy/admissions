@extends('layouts.app')

@section('title', 'Applications Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-alt me-2"></i>Applications Management</h2>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.applications.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="program" class="form-label">Program</label>
                    <input type="text" name="program" id="program" class="form-control" 
                           value="{{ request('program') }}" placeholder="Program name...">
                </div>
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           value="{{ request('search') }}" placeholder="Applicant name or email...">
                </div>
                <div class="col-md-2">
                    <label class="form-label d-block">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Applications Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Applicant</th>
                        <th>Email</th>
                        <th>Program</th>
                        <th>GPA</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                    <tr>
                        <td>#{{ str_pad($application->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $application->first_name ?? $application->user->name }}</td>
                        <td>{{ $application->user->email }}</td>
                        <td>{{ $application->program_choice }}</td>
                        <td>{{ $application->gpa ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $application->status_color }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                        <td>
                            {{ optional($application->submitted_at)->format('M d, Y') ?? '—' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.applications.show', $application) }}" 
                               class="btn btn-sm btn-outline-primary" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open me-2"></i>No applications found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $applications->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
