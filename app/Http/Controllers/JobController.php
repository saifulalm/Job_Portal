<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     * This will be our public job board.
     */
    public function index(Request $request)
    {
        // Start with a query builder instance
        $query = Job::query();

        // Eager load the company profile and user to avoid N+1 issues
        $query->with('companyProfile.user');

        // Handle search by title or description
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Handle filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        // Handle filter by job type
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->input('job_type'));
        }

        // Get the final results, ordered by the newest first
        $jobs = $query->latest()->paginate(10)->withQueryString();


        return view('welcome', compact('jobs'));
    }

    /**
     * Display the specified resource.
     * This is the single job details page.
     */
    public function show(Job $job)
    {
        // Eager load the company profile and its associated user
        $job->load('companyProfile.user');
        return view('jobs.show', compact('job'));
    }
}
