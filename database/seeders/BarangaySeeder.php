<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Barangay::CAPAS_BARANGAYS as $name) {
            Barangay::query()->firstOrCreate(['name' => $name]);
        }
    }
}
