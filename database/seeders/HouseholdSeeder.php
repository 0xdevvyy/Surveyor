<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\Household;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HouseholdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangays = Barangay::query()->orderBy('name')->get();

        foreach ($barangays as $barangayIndex => $barangay) {
            $householdCount = ($barangayIndex % 3) + 2;
            $barangaySlug = Str::slug($barangay->name);

            for (
                $householdIndex = 1;
                $householdIndex <= $householdCount;
                $householdIndex++
            ) {
                $residentEmail = "demo.resident.{$barangaySlug}.{$householdIndex}@example.test";
                $resident = User::query()->where('email', $residentEmail)->first();

                if ($resident === null) {
                    $resident = User::factory()->resident()->create([
                        'email' => $residentEmail,
                    ]);
                }

                $householdNumber = sprintf(
                    'CAPAS-%02d-%02d',
                    $barangayIndex + 1,
                    $householdIndex,
                );

                if (! Household::query()->where('household_number', $householdNumber)->exists()) {
                    Household::factory()
                        ->for($resident)
                        ->for($barangay)
                        ->create(['household_number' => $householdNumber]);
                }
            }
        }
    }
}
