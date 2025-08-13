<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentApplicationWizardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Start at step 1
    public function startApplication()
    {
        return redirect()->route('student.application.step', 1);
    }

    // Just go to the dashboard after submission
    public function submitApplication(Request $request)
    {
        return redirect()->route('student.dashboard')
            ->with('success', 'Application submitted (demo mode, no database).');
    }

    // PDF export disabled for demo
    public function exportPdf()
    {
        abort(404, 'PDF export disabled in demo mode.');
    }

    // Show step view only
    public function showStep($step)
    {
        // No DB — just pass null for $application
        $application = null;
        return view("student.applications.step{$step}", compact('application'));
    }

    // Post step — skip saving, just go to next step
    public function postStep(Request $request, $step)
    {
        $nextStep = min($step + 1, 11);

        if ((int) $step === 11) {
            return redirect()->route('student.dashboard')
                ->with('success', 'Application submitted successfully (demo mode).');
        }

        return redirect()->route('student.application.step', $nextStep);
    }
}
