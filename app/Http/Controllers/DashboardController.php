<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\SurveyQuestion;
use App\Models\User;
use Illuminate\Http\Request;
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
        ]);
    }

    public function surveyorDashboard(Request $request): Response
    {
        $user = $this->authenticatedUser($request);

        return Inertia::render('dashboard/Surveyor', [
            'metrics' => [
                'surveysToday' => $user
                    ->surveysAsSurveyor()
                    ->whereDate('created_at', today())
                    ->count(),
                'submittedSurveys' => $user->surveysAsSurveyor()->count(),
                'residentsReached' => $user->surveysAsSurveyor()->distinct()->count('residents_id'),
            ],
        ]);
    }

    public function residentDashboard(Request $request): Response
    {
        $user = $this->authenticatedUser($request);

        return Inertia::render('dashboard/Resident', [
            'metrics' => [
                'householdRecords' => $user->households()->count(),
                'surveyRecords' => $user->surveysAsResident()->count(),
                'hasPersonalInformation' => $user->personalInformation()->exists(),
            ],
        ]);
    }

    private function authenticatedUser(Request $request): User
    {
        $user = $request->user();

        if (! ($user instanceof User)) {
            abort(404);
        }

        return $user;
    }
}
