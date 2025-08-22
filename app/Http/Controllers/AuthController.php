<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback from Google
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check if user already exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // New user -> create
            $user = User::create([
                'first_name' => $googleUser->user['given_name'] ?? $googleUser->name, // fallback to full name
                'surname' => $googleUser->user['family_name'] ?? '', // fallback empty if unavailable
                'email' => $googleUser->getEmail(),
                'role'  => 'applicant', // default role
                'password' => bcrypt(str()->random(16)), // dummy password
            ]);
        }

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('student.dashboard');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect admin to admin dashboard
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            }

            // ✅ For students, check if they have an application
            if ($user->role === 'student' && $user->applications()->count() === 0) {
                return redirect()->route('student.applications.create')->with('success', 'Welcome! Please complete your application to proceed.');
            }

            // If application exists
            return redirect()->route('student.dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Step 1: show begin.blade.php (basic info form)
    public function showStep1()
    {
        return view('auth.begin');
    }

    // Step 1: handle submission of begin form
    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'id_number' => ['required', 'regex:/^\d{2}-\d{6,7}-[A-Z]-\d{2}$/'],
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date|before:' . now()->subYears(16)->format('Y-m-d'),
            'referral_source' => 'required|string|max:255',
        ]);

        if (User::where('id_number', $validated['id_number'])->exists()) {
            return back()->withErrors(['id_number' => 'ID Number already registered. Please login or reset your password.'])->withInput();
        }

        Session::put('registration_data', $validated);
        return redirect()->route('register');
    }

    // Step 2: show register.blade.php (password setup)
    public function showStep2()
    {
        $data = Session::get('registration_data');

        if (!$data) {
            return redirect()->route('register.begin')->withErrors('Please start registration first.');
        }

        return view('auth.register', ['data' => $data]);
    }

    // ✅ Step 2: complete registration + redirect to application form if not submitted
    public function postStep2(Request $request)
    {
        $data = Session::get('registration_data');

        if (!$data) {
            return redirect()->route('register.begin')->withErrors('Session expired. Please start registration again.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'id_number' => $data['id_number'],
            'surname' => $data['surname'],
            'first_name' => $data['first_name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'],
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        Auth::login($user);
        Session::forget('registration_data');

        // ✅ Redirect to application form if none exists
        if ($user->applications()->count() === 0) {
            return redirect()->route('student.applications.create')->with('success', 'Welcome! Please complete your application to get started.');
        }

        return redirect()->route('student.dashboard')->with('success', 'Registration completed successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
