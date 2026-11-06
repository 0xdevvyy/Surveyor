<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Barangay;
use App\Models\SurveyQuestion;
use App\Models\User;
use App\Queries\SurveyStats\HouseholdBarangaysQuery;
use App\Queries\SurveyStats\SurveyProgressByBarangayQuery;
use App\Queries\UsersQuery;
use Illuminate\Container\Attributes\Authenticated;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function adminDashboard(
        Request $request,
        UsersQuery $usersQuery,
        HouseholdBarangaysQuery $householdBarangaysQuery,
        SurveyProgressByBarangayQuery $surveyProgressByBarangayQuery,
    ): Response {
        $lengthAwarePaginator = $usersQuery
            ->queryForAdmin()
            ->latest()
            ->paginate(2);

        return Inertia::render('dashboard/Admin', [
            'metrics' => [
                'registeredUsers' => User::query()->count(),
                'surveySubmissions' => SurveyQuestion::query()->count(),
                'barangays' => Barangay::query()->count(),
            ],
            'users' => [
                ...$lengthAwarePaginator->toArray(),
                'data' => UserResource::collection($lengthAwarePaginator)
                    ->resolve($request),
            ],
            'householdBarangays' => $householdBarangaysQuery->get(),
            'surveyProgressByBarangay' => $surveyProgressByBarangayQuery->get(),
        ]);
    }

    public function surveyorDashboard(#[Authenticated()] User $user, HouseholdBarangaysQuery $householdBarangaysQuery, SurveyProgressByBarangayQuery $surveyProgressByBarangayQuery): Response
    {
        return Inertia::render('dashboard/Surveyor', [
            'metrics' => [
                'surveysToday' => $user
                    ->surveysAsSurveyor()
                    ->whereDate('created_at', today())
                    ->count(),
                'submittedSurveys' => $user->surveysAsSurveyor()->count(),
                'residentsReached' => $user->surveysAsSurveyor()->distinct()->count('residents_id'),
            ],
            'householdBarangays' => $householdBarangaysQuery->get(),
            'surveyProgressByBarangay' => $surveyProgressByBarangayQuery->get(),
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
