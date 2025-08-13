<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Application;
use App\Models\User;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\PaymentApproved;
use App\Notifications\PaymentRejected;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_applications' => Application::count(),
            'pending_applications' => Application::pending()->count(),
            'approved_applications' => Application::approved()->count(),
            'rejected_applications' => Application::rejected()->count(),
            'total_students' => User::where('role', 'student')->count(),
        ];

        $recent_applications = Application::with('user')
            ->latest('submitted_at')
            ->take(5)
            ->get();

        $program_stats = Application::selectRaw('program_choice, COUNT(*) as count')
            ->groupBy('program_choice')
            ->pluck('count', 'program_choice')
            ->toArray();

        return view('admin.dashboard', compact('stats', 'recent_applications', 'program_stats'));
    }

    public function index(Request $request)
    {
        $query = Application::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('program')) {
            $query->where('program_choice', 'like', '%' . $request->program . '%');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('email', 'like', "%$search%");
                  });
            });
        }

        $applications = $query->orderBy('submitted_at', 'desc')->paginate(10)->withQueryString();
        $programs = Application::distinct()->pluck('program_choice')->sort();

        return view('admin.applications.index', compact('applications', 'programs'));
    }

    public function show(Application $application)
    {
        $application->load('user');
        return view('admin.applications.show', compact('application'));
    }

    public function edit(Application $application)
    {
        $application->load('user');
        return view('admin.applications.edit', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $application->update($validated);

        $statusMessage = match ($validated['status']) {
            'approved' => 'Application has been approved successfully!',
            'rejected' => 'Application has been rejected.',
            'pending' => 'Application status has been reset to pending.',
        };

        return redirect()->route('admin.applications.show', $application)
            ->with('success', $statusMessage);
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->route('admin.applications.index')
            ->with('success', 'Application has been deleted successfully.');
    }

    public function updateApplicationStatus(Request $request, Application $application)
    {
        return $this->update($request, $application);
    }

    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'application_ids' => 'required|array',
            'application_ids.*' => 'exists:applications,id',
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        Application::whereIn('id', $validated['application_ids'])
            ->update([
                'status' => $validated['status'],
                'admin_notes' => $validated['admin_notes'],
                'updated_at' => now(),
            ]);

        $count = count($validated['application_ids']);
        return redirect()->back()->with('success', "{$count} applications updated successfully.");
    }

    public function downloadDocument(Application $application)
    {
        if (!$application->document_path || !Storage::disk('public')->exists($application->document_path)) {
            return redirect()->back()->with('error', 'No document found or file missing.');
        }

        return Storage::disk('public')->download($application->document_path);
    }

    public function exportApplications(Request $request)
    {
        // Placeholder for export logic
        return redirect()->back()->with('info', 'Export functionality coming soon.');
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function getDashboardStats()
    {
        return response()->json([
            'total_applications' => Application::count(),
            'pending_applications' => Application::pending()->count(),
            'approved_applications' => Application::approved()->count(),
            'rejected_applications' => Application::rejected()->count(),
        ]);
    }

    public function listPayments(Request $request)
    {
        $status = $request->query('status');

        $query = Payment::with('application.user')->latest();

        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $payments = $query->get();

        return view('admin.payments.index', compact('payments', 'status'));
    }

    public function approvePayment(Payment $payment)
    {
        $payment->update([
            'status' => 'approved',
            'payment_status' => 'Approved',
        ]);

        if ($payment->application && $payment->application->user) {
            $payment->application->user->notify(new PaymentApproved());
        }

        // Submit application if not yet submitted
        if (!$payment->application->submitted_at) {
            $payment->application->submitted_at = now();
            $payment->application->save();
        }

        return back()->with('success', 'Payment approved and application submitted.');
    }

    public function rejectPayment(Payment $payment)
    {
        $payment->update(['status' => 'rejected']);

        if ($payment->application && $payment->application->user) {
            $payment->application->user->notify(new PaymentRejected($payment));
        }

        return back()->with('error', 'Payment rejected and user notified.');
    }
    public function deletePayment(Payment $payment)
    {
        if ($payment->file_path) {
            Storage::disk('public')->delete($payment->file_path);
        }

        $payment->delete();
        return back()->with('success', 'Payment deleted.');
    }

    public function downloadPayment(Payment $payment)
    {
        $pdf = Pdf::loadView('admin.payments.pdf', compact('payment'));
        return $pdf->download("payment-{$payment->id}.pdf");
    }
}
