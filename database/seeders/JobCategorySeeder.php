<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kasir',
                'description' => 'Bertugas melayani pembayaran pelanggan dan mengelola kasir toko',
            ],
            [
                'name' => 'Pramuniaga',
                'description' => 'Melayani pelanggan, menata barang, dan menjaga kebersihan toko',
            ],
            [
                'name' => 'Supervisor Toko',
                'description' => 'Mengawasi operasional toko dan mengelola karyawan',
            ],
            [
                'name' => 'Admin Gudang',
                'description' => 'Mengelola stok barang dan administrasi gudang',
            ],
            [
                'name' => 'Driver/Pengantar',
                'description' => 'Mengantar barang pesanan pelanggan',
            ],
            [
                'name' => 'Cleaning Service',
                'description' => 'Menjaga kebersihan dan kerapihan toko',
            ],
            [
                'name' => 'Security',
                'description' => 'Menjaga keamanan toko dan barang dagangan',
            ],
        ];

        foreach ($categories as $category) {
            JobCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
}