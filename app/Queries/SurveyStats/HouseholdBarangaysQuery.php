<?php

declare(strict_types=1);

namespace App\Queries\SurveyStats;

use App\Models\Barangay;
use Illuminate\Support\Collection;

class HouseholdBarangaysQuery
{
    /**
     * @return Collection<int, array{name: string, households: int}>
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
            ->select('barangays.id', 'barangays.name')
            ->selectRaw('COUNT(households.id) AS households')
            ->groupBy('barangays.id', 'barangays.name')
            ->orderBy('barangays.name')
            ->get()
            ->map(fn (Barangay $barangay): array => [
                'name' => $barangay->name,
                'households' => (int) $barangay->getAttribute('households'),
            ]);
    }
}
