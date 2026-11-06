<?php

namespace Database\Factories;

use App\Enum\BloodTypeEnum;
use App\Enum\GenderEnum;
use App\Enum\SuffixEnum;
use App\Models\PersonalInformation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PersonalInformation>
 */
class PersonalInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $birthdate = fake()->dateTimeBetween('-80 years', '-18 years');

        return [
            'user_id' => User::factory()->resident(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->optional()->firstName(),
            'last_name' => fake()->lastName(),
            'suffix' => fake()->optional()->randomElement(
                array_map(
                    fn (SuffixEnum $suffix): string => $suffix->value,
                    SuffixEnum::cases(),
                ),
            ),
            'blood_type' => fake()->optional()->randomElement(
                array_map(
                    fn (BloodTypeEnum $bloodType): string => $bloodType->value,
                    BloodTypeEnum::cases(),
                ),
            ),
            'gender' => fake()->randomElement(GenderEnum::cases())->value,
            'age' => abs((int) now()->diffInYears($birthdate)),
            'birthdate' => $birthdate->format('Y-m-d'),
            'phone_number' => fake()->numerify('09#########'),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
