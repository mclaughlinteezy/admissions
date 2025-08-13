{{-- resources/views/student/applications/submit.blade.php --}}
@extends('layouts.app')

@section('content')
    <script>
        window.location.href = "{{ route('student.application.step', ['step' => 1]) }}";
    </script>
@endsection
