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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'employer', 'job_seeker'])->default('job_seeker')->comment('User role in the system');
            $table->string('phone')->nullable()->comment('User phone number');
            $table->text('address')->nullable()->comment('User address');
            $table->date('date_of_birth')->nullable()->comment('Date of birth for job seekers');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->comment('Gender');
            $table->text('bio')->nullable()->comment('User biography or description');
            $table->boolean('is_active')->default(true)->comment('Whether user account is active');
            
            $table->index('role');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'phone', 'address', 'date_of_birth', 
                'gender', 'bio', 'is_active'
            ]);
        });
    }
};