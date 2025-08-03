<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobApplicationRequest;
use App\Http\Requests\UpdateJobApplicationRequest;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if ($user->isJobSeeker()) {
            // Show user's own applications
            $applications = JobApplication::with(['job.category', 'job.user'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
                
            return Inertia::render('applications/index', [
                'applications' => $applications,
                'userRole' => 'job_seeker',
            ]);
        } elseif ($user->isEmployer()) {
            // Show applications for user's jobs
            $applications = JobApplication::with(['job.category', 'user'])
                ->whereHas('job', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest()
                ->paginate(10);
                
            return Inertia::render('applications/index', [
                'applications' => $applications,
                'userRole' => 'employer',
            ]);
        } else {
            // Admin - show all applications
            $applications = JobApplication::with(['job.category', 'job.user', 'user'])
                ->latest()
                ->paginate(10);
                
            return Inertia::render('applications/index', [
                'applications' => $applications,
                'userRole' => 'admin',
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jobId = $request->query('job_id');
        $job = Job::with(['category', 'user'])->findOrFail($jobId);
        
        // Check if user already applied
        $existingApplication = JobApplication::where('job_id', $jobId)
            ->where('user_id', auth()->id())
            ->first();
            
        if ($existingApplication) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'Anda sudah melamar untuk lowongan ini.');
        }
        
        return Inertia::render('applications/create', [
            'job' => $job,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobApplicationRequest $request)
    {
        $job = Job::findOrFail($request->job_id);
        
        // Check if user already applied
        $existingApplication = JobApplication::where('job_id', $job->id)
            ->where('user_id', auth()->id())
            ->first();
            
        if ($existingApplication) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'Anda sudah melamar untuk lowongan ini.');
        }

        $application = JobApplication::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Lamaran berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobApplication $jobApplication)
    {
        $user = auth()->user();
        
        // Check permissions
        if ($user->isJobSeeker() && $jobApplication->user_id !== $user->id) {
            abort(403);
        } elseif ($user->isEmployer() && $jobApplication->job->user_id !== $user->id) {
            abort(403);
        }
        
        $jobApplication->load(['job.category', 'job.user', 'user']);
        
        return Inertia::render('applications/show', [
            'application' => $jobApplication,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $jobApplication)
    {
        // Only applicant can edit their own application (and only if still pending)
        if ($jobApplication->user_id !== auth()->id() || $jobApplication->status !== 'pending') {
            abort(403);
        }
        
        $jobApplication->load(['job.category']);
        
        return Inertia::render('applications/edit', [
            'application' => $jobApplication,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobApplicationRequest $request, JobApplication $jobApplication)
    {
        $user = auth()->user();
        
        if ($user->isJobSeeker()) {
            // Job seeker can only update their own pending application
            if ($jobApplication->user_id !== $user->id || $jobApplication->status !== 'pending') {
                abort(403);
            }
            
            $jobApplication->update($request->only([
                'applicant_name', 'applicant_phone', 'applicant_email', 
                'applicant_address', 'cover_letter', 'experience', 'skills'
            ]));
        } elseif ($user->isEmployer() || $user->isAdmin()) {
            // Employer/Admin can update status and notes
            if ($user->isEmployer() && $jobApplication->job->user_id !== $user->id) {
                abort(403);
            }
            
            $updateData = $request->only(['status', 'notes']);
            if ($request->status !== 'pending') {
                $updateData['reviewed_at'] = now();
            }
            
            $jobApplication->update($updateData);
        }

        return redirect()->route('job-applications.show', $jobApplication)
            ->with('success', 'Data lamaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        $user = auth()->user();
        
        // Only applicant (if pending) or admin can delete
        if ($user->isJobSeeker() && ($jobApplication->user_id !== $user->id || $jobApplication->status !== 'pending')) {
            abort(403);
        } elseif ($user->isEmployer() && $jobApplication->job->user_id !== $user->id) {
            abort(403);
        }

        $jobApplication->delete();

        return redirect()->route('job-applications.index')
            ->with('success', 'Lamaran berhasil dihapus!');
    }
}