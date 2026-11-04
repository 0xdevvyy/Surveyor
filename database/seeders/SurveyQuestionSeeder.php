<?php

namespace Database\Seeders;

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
        $surveyorEmail = 'demo.surveyor@example.test';
        $surveyor = User::query()->where('email', $surveyorEmail)->first();

        if ($surveyor === null) {
            $surveyor = User::factory()->surveyor()->create([
                'name' => 'Demo Surveyor',
                'email' => $surveyorEmail,
            ]);
        }

        Household::query()
            ->with('user')
            ->orderBy('household_number')
            ->get()
            ->each(function (Household $household, int $index) use ($surveyor): void {
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
                    ->for($surveyor, 'surveyor')
                    ->for($household->user, 'resident')
                    ->create(['created_at' => $createdAt]);
            });
    }
}
