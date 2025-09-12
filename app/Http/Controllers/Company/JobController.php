<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the logged-in user's company profile
        $companyProfile = Auth::user()->companyProfile;

        // Fetch only the jobs related to this company
        $jobs = $companyProfile->jobs()->latest()->paginate(10);

        return view('company.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'job_type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $companyProfile = Auth::user()->companyProfile;

        $companyProfile->jobs()->create([
            'title' => $request->title,
            'job_type' => $request->job_type,
            'location' => $request->location,
            'salary' => $request->salary,
            'description' => $request->description,
        ]);

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        // Authorization: Ensure the job belongs to the logged-in company
        if ($job->company_profile_id !== Auth::user()->companyProfile->id) {
            abort(403);
        }

        return view('company.jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        // Authorization: Ensure the job belongs to the logged-in company
        if ($job->company_profile_id !== Auth::user()->companyProfile->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'job_type' => 'required|string|in:Full-time,Part-time,Contract,Internship',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $job->update($request->all());

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        // Authorization: Ensure the job belongs to the logged-in company
        if ($job->company_profile_id !== Auth::user()->companyProfile->id) {
            abort(403);
        }

        $job->delete();

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }
}
