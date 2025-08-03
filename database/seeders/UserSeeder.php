<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Loker Madura',
            'email' => 'admin@lokermadura.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Pamekasan, Madura',
            'bio' => 'Administrator sistem loker toko kelontong Madura',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create sample employers
        User::create([
            'name' => 'Toko Sari Madura',
            'email' => 'sari@tokosari.com',
            'password' => Hash::make('password'),
            'role' => 'employer',
            'phone' => '081234567891',
            'address' => 'Jl. Trunojoyo No. 123, Bangkalan, Madura',
            'bio' => 'Toko kelontong terlengkap di Bangkalan sejak 1985',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Warung Berkah Jaya',
            'email' => 'berkah@warungjaya.com',
            'password' => Hash::make('password'),
            'role' => 'employer',
            'phone' => '081234567892',
            'address' => 'Jl. Raya Pamekasan No. 456, Pamekasan, Madura',
            'bio' => 'Warung kelontong keluarga yang melayani kebutuhan sehari-hari',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create sample job seekers
        User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'role' => 'job_seeker',
            'phone' => '081234567893',
            'address' => 'Sumenep, Madura',
            'date_of_birth' => '1995-05-15',
            'gender' => 'male',
            'bio' => 'Lulusan SMA dengan pengalaman kerja di toko retail selama 2 tahun',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Fatimah',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'job_seeker',
            'phone' => '081234567894',
            'address' => 'Sampang, Madura',
            'date_of_birth' => '1998-08-20',
            'gender' => 'female',
            'bio' => 'Fresh graduate yang siap bekerja keras dan belajar hal baru',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}