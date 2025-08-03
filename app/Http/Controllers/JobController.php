<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Job::with(['category', 'user'])
            ->published()
            ->active()
            ->latest('published_at');

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search by title or store name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('store_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by work type
        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        // Filter by salary range
        if ($request->filled('salary_min')) {
            $query->where('salary_max', '>=', $request->salary_min);
        }

        $jobs = $query->paginate(12)->withQueryString();
        $categories = JobCategory::active()->orderBy('name')->get();

        return Inertia::render('jobs/index', [
            'jobs' => $jobs,
            'categories' => $categories,
            'filters' => $request->only(['category', 'search', 'work_type', 'salary_min']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = JobCategory::active()->orderBy('name')->get();
        
        return Inertia::render('jobs/create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
        $job = Job::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
            'published_at' => now(),
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Lowongan berhasil diposting!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $job->load(['category', 'user', 'applications' => function ($query) {
            $query->where('user_id', auth()->id());
        }]);

        $hasApplied = $job->applications->isNotEmpty();

        return Inertia::render('jobs/show', [
            'job' => $job,
            'hasApplied' => $hasApplied,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        // Only allow job owner or admin to edit
        if ($job->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = JobCategory::active()->orderBy('name')->get();
        
        return Inertia::render('jobs/edit', [
            'job' => $job,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        // Only allow job owner or admin to update
        if ($job->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $job->update($request->validated());

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Lowongan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        // Only allow job owner or admin to delete
        if ($job->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan berhasil dihapus!');
    }
}