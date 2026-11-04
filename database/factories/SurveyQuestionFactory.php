<?php

namespace Database\Factories;

use App\Models\Household;
use App\Models\SurveyQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SurveyQuestion>
 */
class SurveyQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'surveyor_id' => User::factory()->surveyor(),
            'residents_id' => User::factory()->resident(),
            'household_size' => fake()->numberBetween(1, 10),
            'relationship_to_household_head' => fake()->randomElement([
                'Head',
                'Spouse',
                'Child',
                'Other relative',
            ]),
            'educational_attainment' => fake()->randomElement([
                'Elementary',
                'High school',
                'College',
                'No formal education',
            ]),
            'employment_status' => fake()->randomElement([
                'Employed',
                'Unemployed',
                'Self-employed',
            ]),
            'occupation' => fake()->jobTitle(),
            'monthly_income' => fake()->numberBetween(0, 100000),
            'housing_type' => fake()->randomElement([
                'Concrete',
                'Wood',
                'Mixed materials',
            ]),
            'house_ownership' => fake()->randomElement([
                'Owned',
                'Rented',
                'Shared',
            ]),
            'has_electricity' => fake()->boolean(),
            'water_source' => fake()->randomElement([
                'Water district',
                'Community well',
                'Other',
            ]),
            'has_internet' => fake()->boolean(),
            'receives_government_assistance' => fake()->boolean(),
            'is_4p_member' => fake()->boolean(),
            'is_senior_beneficiary_member' => fake()->boolean(),
            'other_concerns' => fake()->optional()->sentence(),
        ];
    }

    public function forHousehold(Household $household): static
    {
        return $this->state(fn (array $attributes) => [
            'residents_id' => $household->user_id,
        ]);
    }
}
