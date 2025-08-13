<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;

class CheckApplicationStep
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Fetch the latest application by the user
        $application = Application::where('user_id', $user->id)->latest()->first();

        // If no application yet, redirect to step 1
        if (!$application) {
            return redirect()->route('student.application.step', 1)
                ->with('info', 'Please start your application.');
        }

        // Redirect if user tries to access step out of order
        $currentStep = $application->current_step ?? 1;
        $requestedStep = (int) $request->route('step');

        // If trying to skip ahead, redirect to current step
        if ($requestedStep > $currentStep) {
            return redirect()->route('student.application.step', $currentStep)
                ->with('info', 'Please complete the current step before moving forward.');
        }

        return $next($request);
    }
}
