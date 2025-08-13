<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(Application $application)
    {
        $this->authorize('view', $application); // Optional

        $payments = $application->payments;
        return view('student.payments.index', compact('application', 'payments'));
    }

    public function download(Application $application, Payment $payment)
    {
        if ($payment->application_id !== $application->id) {
            abort(403);
        }

        return Storage::disk('public')->download($payment->proof_file_path);
    }
}

