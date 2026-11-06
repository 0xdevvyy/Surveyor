<?php

namespace Database\Factories;

use App\Models\Barangay;
use App\Models\Household;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Household>
 */
class HouseholdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'household_number' => 'HH-'.fake()->unique()->numerify('######'),
            'user_id' => User::factory()->resident(),
            'barangay_id' => Barangay::factory(),
        ];
    }
}
