<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('applicant_name')->comment('Full name of applicant');
            $table->string('applicant_phone')->comment('Phone number of applicant');
            $table->string('applicant_email')->comment('Email of applicant');
            $table->text('applicant_address')->comment('Address of applicant');
            $table->text('cover_letter')->nullable()->comment('Cover letter or message');
            $table->text('experience')->nullable()->comment('Work experience description');
            $table->text('skills')->nullable()->comment('Skills and qualifications');
            $table->string('cv_file_path')->nullable()->comment('Path to uploaded CV file');
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'interviewed', 'accepted', 'rejected'])->default('pending')->comment('Application status');
            $table->text('notes')->nullable()->comment('Admin or employer notes');
            $table->timestamp('reviewed_at')->nullable()->comment('When application was reviewed');
            $table->timestamps();
            
            $table->unique(['job_id', 'user_id'], 'unique_job_application');
            $table->index('status');
            $table->index(['job_id', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};