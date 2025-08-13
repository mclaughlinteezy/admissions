@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Payments for Application #{{ $application->id }}</h3>

    @if($payments->isEmpty())
        <p>No payment records found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>From Bank</th>
                    <th>To Bank</th>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Proof</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_date }}</td>
                        <td>{{ $payment->bank_from }}</td>
                        <td>{{ $payment->bank_to }}</td>
                        <td>{{ $payment->payment_reference }}</td>
                        <td>${{ number_format($payment->amount_paid, 2) }}</td>
                        <td>
                            @if($payment->proof_file_path)
                                <a href="{{ route('student.payments.download', [$application->id, $payment->id]) }}" class="btn btn-sm btn-primary">Download</a>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('student.application.step', 10) }}" class="btn btn-secondary">Back to Payment Form</a>
</div>
@endsection
