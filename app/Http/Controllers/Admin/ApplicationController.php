<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::latest()->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }

    public function show($id)
    {
        $application = Application::findOrFail($id);
        return view('admin.applications.show', compact('application'));
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $application->update($request->only(['status']));
        return redirect()->back()->with('success', 'Status updated.');
    }

    public function destroy($id)
    {
        Application::findOrFail($id)->delete();
        return redirect()->route('admin.applications.index')->with('success', 'Application deleted.');
    }
}