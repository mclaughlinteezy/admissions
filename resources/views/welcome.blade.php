@extends('layouts.app')

@section('title', 'MSU Admission System')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="hero-section py-5">
                <h1 class="display-4 mb-4">Welcome to Our University</h1>
                <p class="lead mb-4">Join thousands of students who have started their academic journey with us. Apply now and take the first step towards your future.</p>
                
                @guest
                    <div class="row justify-content-center">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">New Applicant?</h5>
                                    <p class="card-text">Create an account to start your application process</p>
                                    <a href="{{ route('register.begin') }}" class="btn btn-primary">Register Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-sign-in-alt fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Already Registered?</h5>
                                    <p class="card-text">Sign in to continue your application</p>
                                    <a href="{{ route('login') }}" class="btn btn-success">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Welcome back, {{ Auth::user()->name }}!</h5>
                            <p class="card-text">Continue your admission journey</p>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Go to Admin Dashboard</a>
                            @else
                                <a href="{{ route('student.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                            @endif
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
<footer class="text-center py-4">
        <p>&copy; {{ date('Y') }} Midlands State University Admission System. All rights reserved.</p>
    </footer>
@endsection
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('main-content')
            </div>
        </div>
    </div> 
</div>
</div>
