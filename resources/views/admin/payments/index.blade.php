@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <form method="GET" class="form-inline">
            <label class="mr-2">Filter by Status:</label>
            <select name="status" class="form-control mr-2" onchange="this.form.submit()">
                <option value="">-- All --</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </form>
    </div>

    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Applicant</th>
                <th>Bank From</th>
                <th>Bank To</th>
                <th>Reference</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Proof</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->application->user->name ?? '-' }}</td>
                    <td>{{ $payment->bank_from ?? '-' }}</td>
                    <td>{{ $payment->bank_to ?? '-' }}</td>
                    <td>{{ $payment->payment_reference ?? '-' }}</td>
                    <td>${{ number_format($payment->amount_paid, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $payment->status === 'approved' ? 'success' : 
                            ($payment->status === 'rejected' ? 'danger' : 'warning') 
                        }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td>
                        @if($payment->proof_file_path)
                            <a href="{{ asset('storage/' . $payment->proof_file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        @if($payment->status === 'pending')
                            <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success">Approve</button>
                            </form>

                            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-warning">Reject</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.payments.delete', $payment) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>

                        <a href="{{ route('admin.payments.download', $payment) }}" class="btn btn-sm btn-info">PDF</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">No payments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
