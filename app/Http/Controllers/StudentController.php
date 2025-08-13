<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Applicant;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('student.dashboard');
    }
    public function profile()
    {
        // Get applicant record for logged-in user, or null if none
        $applicant = Applicant::where('user_id', Auth::id())->first();

        return view('student.profile', compact('applicant'));
    }

    public function updateProfile(Request $request)
    {
        // Validate input based on your applicants table schema
        $validated = $request->validate([
            'title' => 'nullable|string|max:10',
            'surname' => 'required|string|max:100',
            'first_names' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female,Other',
            'national_id' => 'nullable|string|max:50',
            'dob' => 'required|date',
            'place_of_birth' => 'nullable|string|max:100',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'country_id' => 'nullable|integer|exists:countries,id',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'citizenship' => 'nullable|string|max:100',
            'applicant_type' => 'nullable|in:National,International',
            'application_mode' => 'nullable|in:Manual,Online',
        ]);

        // Find existing applicant or create new
        $applicant = Applicant::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('student.profile.show')->with('success', 'Profile updated successfully!');
    }
}
