<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'job_seeker',
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address() . ', Madura',
            'date_of_birth' => fake()->optional()->dateTimeBetween('-50 years', '-18 years'),
            'gender' => fake()->randomElement(['male', 'female']),
            'bio' => fake()->optional()->paragraph(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create an admin user.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'bio' => 'Administrator sistem loker toko kelontong Madura',
        ]);
    }

    /**
     * Create an employer user.
     */
    public function employer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'employer',
            'name' => fake()->randomElement([
                'Toko Sari Madura',
                'Warung Berkah Jaya', 
                'Toko Sembako Bahagia',
                'Warung Madura Asli',
                'Toko Kelontong Sejahtera'
            ]),
            'bio' => 'Toko kelontong yang melayani kebutuhan sehari-hari masyarakat Madura',
        ]);
    }

    /**
     * Create a job seeker user.
     */
    public function jobSeeker(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'job_seeker',
            'bio' => 'Pencari kerja yang siap bekerja keras dan belajar hal baru',
        ]);
    }
}
