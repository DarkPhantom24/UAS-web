<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Categories
        $categories = [
            'Laptop & Komputer',
            'Smartphone',
            'TV & Monitor',
            'Baterai & Aki',
            'Perangkat Jaringan',
            'Lainnya',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        // Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '081200000001',
            'role' => 'admin',
            'is_approved' => true,
            'password' => bcrypt('112233'),
        ]);

        // Kontributor (Masyarakat)
        User::factory()->create([
            'name' => 'Kontributor',
            'email' => 'kontributor@example.com',
            'phone' => '081300000002',
            'role' => 'masyarakat',
            'is_approved' => true,
            'password' => bcrypt('112233'),
        ]);

        // Mitra
        User::factory()->create([
            'name' => 'Mitra',
            'email' => 'mitra@example.com',
            'phone' => '081400000003',
            'role' => 'mitra',
            'nama_lapak' => 'Lapak Mitra',
            'alamat_lapak' => 'Jl. Contoh No. 123, Jakarta',
            'is_approved' => true,
            'password' => bcrypt('112233'),
        ]);
    }
}
