<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Household;
use App\Models\SurveyQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;

class SurveyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surveyors = User::query()
            ->where('role', RoleEnum::SURVEYOR->value)
            ->get();

        if ($surveyors->isEmpty()) {
            $surveyors = collect([
                User::factory()->surveyor()->create([
                    'name' => 'Demo Surveyor',
                    'email' => 'demo.surveyor@example.test',
                ]),
            ]);
        }

        $households = Household::query()
            ->orderBy('household_number')
            ->get();

        foreach ($surveyors as $surveyor) {
            $households->each(
                function (Household $household, int $index) use ($surveyor): void {
                    $alreadySeeded = SurveyQuestion::query()
                        ->where('surveyor_id', $surveyor->getKey())
                        ->where('residents_id', $household->user_id)
                        ->exists();

                    if ($alreadySeeded) {
                        return;
                    }

                    $createdAt = $index < 5
                        ? now()
                        : now()->subDays(($index % 30) + 1);

                    SurveyQuestion::factory()
                        ->forHousehold($household)
                        ->for($surveyor, 'surveyor')
                        ->create(['created_at' => $createdAt]);
                },
            );
        }
    }
}
