<?php

declare(strict_types=1);

namespace App\Queries\SurveyStats;

use App\Models\Barangay;
use Illuminate\Support\Collection;

class SurveyProgressByBarangayQuery
{
    /**
     * @return Collection<int, array{name: string, totalResidents: int, surveyedResidents: int}>
     */
    public function get(): Collection
    {
        return Barangay::query()
            ->leftJoin(
                'households',
                'households.barangay_id',
                '=',
                'barangays.id',
            )
            ->leftJoin(
                'survey_questions',
                'survey_questions.residents_id',
                '=',
                'households.user_id',
            )
            ->select('barangays.id', 'barangays.name')
            ->selectRaw(
                'COUNT(DISTINCT households.user_id) AS total_residents',
            )
            ->selectRaw(
                'COUNT(DISTINCT survey_questions.residents_id) AS surveyed_residents',
            )
            ->groupBy('barangays.id', 'barangays.name')
            ->orderBy('barangays.name')
            ->get()
            ->map(fn (Barangay $barangay): array => [
                'name' => $barangay->name,
                'totalResidents' => (int) $barangay->getAttribute('total_residents'),
                'surveyedResidents' => (int) $barangay->getAttribute('surveyed_residents'),
            ]);
    }
}
