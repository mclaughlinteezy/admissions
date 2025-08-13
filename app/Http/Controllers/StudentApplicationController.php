<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentApplicationController extends Controller
{
    // Step 1 - Attendance
    public function showStep1()
    {
        return view('student.applications.step1_attendance');
    }

    public function postStep1(Request $request)
    {
        $request->validate([
            'attendance_type' => 'required|string|in:full_time,part_time,distance',
        ]);

        $application = session('application', []);
        $application['attendance_type'] = $request->attendance_type;
        session(['application' => $application]);

        return redirect()->route('student.applications.step2');
    }

    // Step 2 - Programme
    public function showStep2()
    {
        if (!session()->has('application.attendance_type')) {
            return redirect()->route('student.applications.step1')->with('error', 'Please complete Step 1 first.');
        }

        return view('student.applications.step2_programme');
    }

    public function postStep2(Request $request)
    {
        $request->validate([
            'programme' => 'required|string',
        ]);

        $application = session('application', []);
        $application['programme'] = $request->programme;
        session(['application' => $application]);

        return redirect()->route('student.applications.step3');
    }

    // Step 3 - O-Level
    public function showStep3()
    {
        if (!session()->has('application.programme')) {
            return redirect()->route('student.applications.step2')->with('error', 'Please complete Step 2 first.');
        }

        return view('student.applications.step3_olevel');
    }

    public function postStep3(Request $request)
    {
        $request->validate([
            'olevel_subjects' => 'required|string',
        ]);

        $application = session('application', []);
        $application['olevel_subjects'] = $request->olevel_subjects;
        session(['application' => $application]);

        return redirect()->route('student.applications.step4');
    }

    // Step 4 - A-Level
    public function showStep4()
    {
        if (!session()->has('application.olevel_subjects')) {
            return redirect()->route('student.applications.step3')->with('error', 'Please complete Step 3 first.');
        }

        return view('student.applications.step4_alevel');
    }

    public function postStep4(Request $request)
    {
        // A-Level subjects can be nullable if user has none
        $request->validate([
            'alevel_subjects' => 'nullable|string',
        ]);

        $application = session('application', []);
        $application['alevel_subjects'] = $request->alevel_subjects;
        session(['application' => $application]);

        return redirect()->route('student.applications.step5');
    }

    // Step 5 - Tertiary
    public function showStep5()
    {
        if (!session()->has('application.alevel_subjects')) {
            return redirect()->route('student.applications.step4')->with('error', 'Please complete Step 4 first.');
        }

        return view('student.applications.step5_tertiary');
    }

    public function postStep5(Request $request)
    {
        $request->validate([
            'tertiary_institution' => 'nullable|string|max:255',
            'tertiary_qualification' => 'nullable|string|max:255',
        ]);

        $application = session('application', []);
        $application['tertiary_institution'] = $request->tertiary_institution;
        $application['tertiary_qualification'] = $request->tertiary_qualification;
        session(['application' => $application]);

        return redirect()->route('student.applications.step6');
    }

    // Step 6 - Experience
    public function showStep6()
    {
        if (!session()->has('application.tertiary_institution')) {
            return redirect()->route('student.applications.step5')->with('error', 'Please complete Step 5 first.');
        }

        return view('student.applications.step6_experience');
    }

    public function postStep6(Request $request)
    {
        $request->validate([
            'work_experience' => 'required|string',
        ]);

        $application = session('application', []);
        $application['work_experience'] = $request->work_experience;
        session(['application' => $application]);

        return redirect()->route('student.applications.step7');
    }

    // Step 7 - Referee
    public function showStep7()
    {
        if (!session()->has('application.work_experience')) {
            return redirect()->route('student.applications.step6')->with('error', 'Please complete Step 6 first.');
        }

        return view('student.applications.step7_referee');
    }

    public function postStep7(Request $request)
    {
        $request->validate([
            'referee_name' => 'required|string|max:255',
            'referee_email' => 'nullable|email|max:255',
            'referee_phone' => 'nullable|string|max:20',
        ]);

        $application = session('application', []);
        $application['referee_name'] = $request->referee_name;
        $application['referee_email'] = $request->referee_email;
        $application['referee_phone'] = $request->referee_phone;
        session(['application' => $application]);

        return redirect()->route('student.applications.step8');
    }

    // Step 8 - Documents (files)
    public function showStep8()
    {
        if (!session()->has('application.referee_name')) {
            return redirect()->route('student.applications.step7')->with('error', 'Please complete Step 7 first.');
        }

        return view('student.applications.step8_documents');
    }

    public function postStep8(Request $request)
    {
        $request->validate([
            'documents' => 'required',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB each
        ]);

        // Store uploaded documents temporarily, or store paths in session
        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('applications/documents'); // adjust path as needed
                $documents[] = $path;
            }
        }

        $application = session('application', []);
        $application['documents'] = $documents;
        session(['application' => $application]);

        return redirect()->route('student.applications.step9');
    }

    // Step 9 - Summary
    public function showStep9()
    {
        if (!session()->has('application.documents')) {
            return redirect()->route('student.applications.step8')->with('error', 'Please complete Step 8 first.');
        }

        return view('student.applications.step9_summary');
    }

    // No post for step 9, just review + proceed button

    // Step 10 - Payment
    public function showStep10()
    {
        if (!session()->has('application.documents')) {
            return redirect()->route('student.applications.step9')->with('error', 'Please complete Step 9 first.');
        }

        return view('student.applications.step10_payment');
    }

    public function postStep10(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:mobile_money,bank_transfer,cash',
            'payment_reference' => 'required|string|max:255',
        ]);

        $application = session('application', []);
        $application['payment_method'] = $request->payment_method;
        $application['payment_reference'] = $request->payment_reference;
        session(['application' => $application]);

        return redirect()->route('student.applications.step11');
    }

    // Step 11 - Proof of Payment Upload
    public function showStep11()
    {
        if (!session()->has('application.payment_method')) {
            return redirect()->route('student.applications.step10')->with('error', 'Please complete Step 10 first.');
        }

        return view('student.applications.step11_proof');
    }

    public function postStep11(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('payment_proof')->store('applications/payment_proofs');

        $application = session('application', []);
        $application['payment_proof'] = $path;
        session(['application' => $application]);

        // At this point, you can save $application to the DB
        // Example: Application::create($application);

        // Clear session data related to application
        session()->forget('application');

        return redirect()->route('student.dashboard')->with('success', 'Application submitted successfully!');
    }
}
