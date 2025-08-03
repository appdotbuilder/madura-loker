<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Main job portal page - show welcome for guests, jobs for authenticated users
Route::get('/', function () {
    if (auth()->check()) {
        return app(JobController::class)->index(request());
    }
    return Inertia::render('welcome');
})->name('home');

// Public job listings
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    
    // Job management (for employers and admins)
    Route::middleware('can:create,App\Models\Job')->group(function () {
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    });
    
    Route::middleware('can:update,job')->group(function () {
        Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    });
    
    // Job applications
    Route::resource('job-applications', JobApplicationController::class)->except(['create', 'store']);
    Route::get('/apply', [JobApplicationController::class, 'create'])->name('job-applications.create');
    Route::post('/job-applications', [JobApplicationController::class, 'store'])->name('job-applications.store');
    
    // My jobs (for employers)
    Route::get('/my-jobs', function () {
        $jobs = auth()->user()->jobs()->with(['category', 'applications'])->latest()->paginate(10);
        return Inertia::render('jobs/my-jobs', ['jobs' => $jobs]);
    })->name('my-jobs')->middleware('can:create,App\Models\Job');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
