<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Http\Requests\StorePersonalInformationRequest;
use App\Http\Requests\UpdatePersonalInformationRequest;
use App\Http\Resources\PersonalInformationResource;
use App\Models\Household;
use App\Models\PersonalInformation;
use App\Models\User;
use Illuminate\Container\Attributes\Authenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PersonalInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonalInformationRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(
        #[Authenticated] User $authenticatedUser,
        User $user,
        Request $request,
    ): Response {
        $personalInformation = $user->personalInformation()
            ->with('user')
            ->firstOrFail();

        Gate::authorize('view', $personalInformation);

        $user->load('households.barangay');

        return Inertia::render('users/Show', [
            'user' => [
                'name' => $user->name,
                'role' => $user->role->value,
            ],
            'personalInformation' => PersonalInformationResource::make($personalInformation)
                ->resolve($request),
            'households' => $user->households
                ->map(fn (Household $household): array => [
                    'id' => $household->id,
                    'householdNumber' => $household->household_number,
                    'barangay' => $household->barangay->name,
                ])
                ->values(),
            'backUrl' => match ($authenticatedUser->role) {
                RoleEnum::ADMIN => route('auth.admin.users.index'),
                RoleEnum::SURVEYOR => route('auth.surveyor.dashboard'),
                RoleEnum::RESIDENT => route('auth.resident.dashboard'),
            },
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalInformation $personalInformation): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonalInformationRequest $request, PersonalInformation $personalInformation): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalInformation $personalInformation): void
    {
        //
    }
}
