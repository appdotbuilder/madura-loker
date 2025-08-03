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
        Schema::dropIfExists('jobs');
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_category_id')->constrained()->onDelete('cascade');
            $table->string('title')->comment('Job title');
            $table->text('description')->comment('Job description');
            $table->string('store_name')->comment('Name of the grocery store');
            $table->text('store_address')->comment('Store address');
            $table->string('store_phone')->comment('Store contact phone');
            $table->decimal('salary_min', 10, 2)->nullable()->comment('Minimum salary offered');
            $table->decimal('salary_max', 10, 2)->nullable()->comment('Maximum salary offered');
            $table->enum('salary_type', ['hourly', 'daily', 'weekly', 'monthly'])->default('monthly')->comment('Salary payment type');
            $table->text('requirements')->nullable()->comment('Job requirements');
            $table->text('benefits')->nullable()->comment('Job benefits');
            $table->enum('work_type', ['full-time', 'part-time', 'contract', 'freelance'])->default('full-time')->comment('Type of work');
            $table->integer('positions_available')->default(1)->comment('Number of positions available');
            $table->date('application_deadline')->nullable()->comment('Application deadline');
            $table->enum('status', ['draft', 'active', 'paused', 'closed', 'expired'])->default('active')->comment('Job posting status');
            $table->timestamp('published_at')->nullable()->comment('When job was published');
            $table->timestamps();
            
            $table->index(['status', 'published_at']);
            $table->index('user_id');
            $table->index('job_category_id');
            $table->index('application_deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};