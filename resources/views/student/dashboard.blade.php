@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt me-2"></i>Student Dashboard</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4 shadow-sm text-center py-5">
            <i class="fas fa-file-plus fa-3x text-muted mb-3"></i>
            <h5>No Application Found</h5>
            <p class="text-muted mb-4">You haven't submitted your application yet. Start your application process now!</p>
            <a href="{{ route('student.application.step.post', 1) }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Start Application
            </a>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Quick Links</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-book me-2"></i>Program Information
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-calendar me-2"></i>Important Dates
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-question-circle me-2"></i>FAQ
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
