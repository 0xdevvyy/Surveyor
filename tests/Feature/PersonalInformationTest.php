<?php

use App\Enum\RoleEnum;
use App\Http\Requests\StorePersonalInformationRequest;
use App\Http\Requests\UpdatePersonalInformationRequest;
use App\Models\Barangay;
use App\Models\Household;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Testing\AssertableInertia as Assert;

test('admins, surveyors, and resident owners can view personal information', function (
    RoleEnum $role,
    bool $isOwner,
    string $backRoute,
): void {
    $owner = User::factory()->resident()->create();
    $viewer = $isOwner
        ? $owner
        : User::factory()->create(['role' => $role]);

    $owner->personalInformation()->create([
        'first_name' => 'Ana',
        'middle_name' => 'Maria',
        'last_name' => 'Santos',
        'suffix' => null,
        'blood_type' => 'O+',
        'gender' => 'Female',
        'age' => 36,
        'birthdate' => '1990-04-12',
        'phone_number' => '09171234567',
        'email' => 'ana@example.test',
    ]);
    Household::factory()
        ->for($owner)
        ->for(Barangay::factory()->create(['name' => 'Santa Rita']))
        ->create(['household_number' => 'HH-2026-0042']);

    $response = $this->actingAs($viewer)
        ->get(route('users.personal-information.show', $owner));

    $response->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Show')
            ->where('user.name', $owner->name)
            ->where('user.role', RoleEnum::RESIDENT->value)
            ->where('personalInformation.firstName', 'Ana')
            ->where('personalInformation.middleName', 'Maria')
            ->where('personalInformation.birthdate', '1990-04-12')
            ->where('personalInformation.phoneNumber', '09171234567')
            ->where('households.0.householdNumber', 'HH-2026-0042')
            ->where('households.0.barangay', 'Santa Rita')
            ->where('backUrl', route($backRoute))
    );
})->with([
    'admin' => [RoleEnum::ADMIN, false, 'auth.admin.users.index'],
    'surveyor' => [RoleEnum::SURVEYOR, false, 'auth.surveyor.dashboard'],
    'resident owner' => [RoleEnum::RESIDENT, true, 'auth.resident.dashboard'],
]);

test('residents cannot view another resident\'s personal information', function (): void {
    $owner = User::factory()->resident()->create();
    $resident = User::factory()->resident()->create();
    $personalInformation = $owner->personalInformation()->create([
        'first_name' => 'Ana',
        'middle_name' => null,
        'last_name' => 'Santos',
        'suffix' => null,
        'blood_type' => null,
        'gender' => 'Female',
        'age' => 36,
        'birthdate' => '1990-04-12',
        'phone_number' => '09171234567',
        'email' => 'ana@example.test',
    ]);

    expect(Gate::forUser($resident)->allows('view', $personalInformation))->toBeFalse();

    $response = $this->actingAs($resident)
        ->get(route('users.personal-information.show', $owner));

    $response->assertForbidden();
});

test('personal information page requires authentication', function (): void {
    $owner = User::factory()->resident()->create();
    $owner->personalInformation()->create([
        'first_name' => 'Ana',
        'middle_name' => null,
        'last_name' => 'Santos',
        'suffix' => null,
        'blood_type' => null,
        'gender' => 'Female',
        'age' => 36,
        'birthdate' => '1990-04-12',
        'phone_number' => '09171234567',
        'email' => 'ana@example.test',
    ]);

    $response = $this->get(route('users.personal-information.show', $owner));

    $response->assertRedirect('/login');
});

test('personal information page returns not found when the user has no profile', function (): void {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->resident()->create();

    $response = $this->actingAs($admin)
        ->get(route('users.personal-information.show', $user));

    $response->assertNotFound();
});

test('personal information requests reject negative ages and accept zero', function (
    string $requestClass,
): void {
    $rules = (new $requestClass)->rules();

    expect(Validator::make(['age' => '-1'], $rules)->fails())->toBeTrue()
        ->and(Validator::make(['age' => '0'], $rules)->passes())->toBeTrue();
})->with([
    'store' => [StorePersonalInformationRequest::class],
    'update' => [UpdatePersonalInformationRequest::class],
]);

test('personal information policies enforce role and owner access', function (
    RoleEnum $role,
    bool $isOwner,
    bool $canView,
): void {
    $owner = User::factory()->resident()->create();
    $viewer = $isOwner
        ? $owner
        : User::factory()->create(['role' => $role]);
    $personalInformation = $owner->personalInformation()->create([
        'first_name' => 'Ana',
        'middle_name' => null,
        'last_name' => 'Santos',
        'suffix' => null,
        'blood_type' => null,
        'gender' => 'Female',
        'age' => 36,
        'birthdate' => '1990-04-12',
        'phone_number' => '09171234567',
        'email' => 'ana@example.test',
    ]);

    expect(Gate::forUser($viewer)->allows('view', $personalInformation))->toBe($canView);
})->with([
    'admin' => [RoleEnum::ADMIN, false, true],
    'surveyor' => [RoleEnum::SURVEYOR, false, true],
    'resident owner' => [RoleEnum::RESIDENT, true, true],
    'other resident' => [RoleEnum::RESIDENT, false, false],
]);
