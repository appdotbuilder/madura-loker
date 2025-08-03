<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobApplication>
 */
class JobApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\JobApplication>
     */
    protected $model = JobApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_id' => Job::factory(),
            'user_id' => User::factory()->jobSeeker(),
            'applicant_name' => $this->faker->name(),
            'applicant_phone' => $this->faker->phoneNumber(),
            'applicant_email' => $this->faker->unique()->safeEmail(),
            'applicant_address' => $this->faker->address() . ', Madura',
            'cover_letter' => $this->faker->optional()->paragraphs(2, true),
            'experience' => $this->faker->optional()->paragraphs(2, true),
            'skills' => $this->faker->optional()->sentence(10),
            'cv_file_path' => null, // For future file upload implementation
            'status' => $this->faker->randomElement([
                'pending', 'pending', 'pending', // Most applications are pending
                'reviewed', 'shortlisted', 'interviewed', 'accepted', 'rejected'
            ]),
            'notes' => $this->faker->optional()->sentence(),
            'reviewed_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}