<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Job>
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salaryMin = $this->faker->numberBetween(2500000, 5000000);
        $salaryMax = $this->faker->numberBetween($salaryMin, $salaryMin + 2000000);
        
        return [
            'user_id' => User::factory()->employer(),
            'job_category_id' => JobCategory::factory(),
            'title' => $this->faker->randomElement([
                'Kasir Toko Kelontong',
                'Pramuniaga Warung',
                'Admin Gudang Sembako',
                'Supervisor Toko',
                'Driver Pengantar',
                'Cleaning Service Toko',
                'Security Warung',
            ]),
            'description' => $this->faker->paragraphs(3, true),
            'store_name' => $this->faker->randomElement([
                'Toko Sari Madura',
                'Warung Berkah Jaya',
                'Toko Sembako Bahagia',
                'Warung Madura Asli',
                'Toko Kelontong Sejahtera',
                'Warung Pak Hasan',
                'Toko Bu Siti',
            ]),
            'store_address' => $this->faker->address() . ', ' . $this->faker->randomElement([
                'Bangkalan', 'Sampang', 'Pamekasan', 'Sumenep'
            ]) . ', Madura',
            'store_phone' => $this->faker->phoneNumber(),
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMax,
            'salary_type' => $this->faker->randomElement(['monthly', 'weekly', 'daily']),
            'requirements' => $this->faker->paragraphs(2, true),
            'benefits' => $this->faker->optional()->paragraphs(2, true),
            'work_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract']),
            'positions_available' => $this->faker->numberBetween(1, 5),
            'application_deadline' => $this->faker->optional()->dateTimeBetween('+1 week', '+2 months'),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'paused']), // Mostly active
            'published_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }
}