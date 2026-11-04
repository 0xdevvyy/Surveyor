<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\SurveyQuestion;
use App\Models\User;
use Illuminate\Container\Attributes\Authenticated;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function adminDashboard(): Response
    {
        return Inertia::render('dashboard/Admin', [
            'metrics' => [
                'registeredUsers' => User::query()->count(),
                'surveySubmissions' => SurveyQuestion::query()->count(),
                'barangays' => Barangay::query()->count(),
            ],
            'users' => User::query()
                ->where('role', '!=', 'admin')
                ->latest()
                ->paginate(2, [
                    'id',
                    'name',
                    'email',
                    'role',
                    'email_verified_at',
                    'created_at',
                ]),
        ]);
    }

    public function surveyorDashboard(#[Authenticated()] User $user): Response
    {
        $householdBarangays = Barangay::query()
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

        return Inertia::render('dashboard/Surveyor', [
            'metrics' => [
                'surveysToday' => $user
                    ->surveysAsSurveyor()
                    ->whereDate('created_at', today())
                    ->count(),
                'submittedSurveys' => $user->surveysAsSurveyor()->count(),
                'residentsReached' => $user->surveysAsSurveyor()->distinct()->count('residents_id'),
            ],
            'householdBarangays' => $householdBarangays,
        ]);
    }

    public function residentDashboard(#[Authenticated()] User $user): Response
    {

        return Inertia::render('dashboard/Resident', [
            'metrics' => [
                'householdRecords' => $user->households()->count(),
                'surveyRecords' => $user->surveysAsResident()->count(),
                'hasPersonalInformation' => $user->personalInformation()->exists(),
            ],
        ]);
    }
}
