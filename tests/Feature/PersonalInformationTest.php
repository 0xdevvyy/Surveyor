<?php

use App\Enum\RoleEnum;
use App\Http\Requests\StorePersonalInformationRequest;
use App\Http\Requests\UpdatePersonalInformationRequest;
use App\Models\Barangay;
use App\Models\Household;
use App\Models\PersonalInformation;
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

test('admins, surveyors, and resident owners can edit personal information', function (
    RoleEnum $role,
    bool $isOwner,
): void {
    $owner = User::factory()->resident()->create();
    $editor = $isOwner
        ? $owner
        : User::factory()->create(['role' => $role]);
    $personalInformation = PersonalInformation::factory()->for($owner)->create();

    $response = $this->actingAs($editor)
        ->get(route('users.personal-information.edit', $personalInformation));

    $response->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Edit')
            ->where('user.id', $owner->id)
            ->where('personalInformation.id', $personalInformation->id)
            ->has('genderOptions')
            ->has('bloodTypeOptions')
            ->has('suffixOptions')
    );
})->with([
    'admin' => [RoleEnum::ADMIN, false],
    'surveyor' => [RoleEnum::SURVEYOR, false],
    'resident owner' => [RoleEnum::RESIDENT, true],
]);

test('residents cannot edit another resident\'s personal information', function (): void {
    $owner = User::factory()->resident()->create();
    $resident = User::factory()->resident()->create();
    $personalInformation = PersonalInformation::factory()->for($owner)->create();

    $response = $this->actingAs($resident)
        ->get(route('users.personal-information.edit', $personalInformation));

    $response->assertForbidden();
});

test('admins, surveyors, and resident owners can update personal details only', function (
    RoleEnum $role,
    bool $isOwner,
): void {
    $owner = User::factory()->resident()->create();
    $editor = $isOwner
        ? $owner
        : User::factory()->create(['role' => $role]);
    $personalInformation = PersonalInformation::factory()->for($owner)->create();
    $household = Household::factory()->for($owner)->create([
        'household_number' => 'HH-2026-0042',
    ]);
    $originalBarangayId = $household->barangay_id;

    $response = $this->actingAs($editor)
        ->put(route('users.personal-information.update', $personalInformation), [
            'first_name' => 'Ana',
            'middle_name' => 'Maria',
            'last_name' => 'Santos',
            'suffix' => 'Jr.',
            'blood_type' => 'O+',
            'gender' => 'female',
            'age' => 36,
            'birthdate' => '1990-04-12',
            'phone_number' => '09171234567',
            'email' => 'ana@example.test',
            'household_number' => 'HH-CHANGED',
            'barangay_id' => Barangay::factory()->create()->id,
        ]);

    $response->assertRedirect(route('users.personal-information.show', $owner));
    $this->assertDatabaseHas('personal_information', [
        'id' => $personalInformation->id,
        'first_name' => 'Ana',
        'middle_name' => 'Maria',
        'last_name' => 'Santos',
        'suffix' => 'Jr.',
        'blood_type' => 'O+',
        'gender' => 'female',
        'age' => 36,
        'phone_number' => '09171234567',
        'email' => 'ana@example.test',
    ]);
    expect($personalInformation->fresh()->birthdate->toDateString())
        ->toBe('1990-04-12');
    $this->assertDatabaseHas('households', [
        'id' => $household->id,
        'household_number' => 'HH-2026-0042',
        'barangay_id' => $originalBarangayId,
    ]);
})->with([
    'admin' => [RoleEnum::ADMIN, false],
    'surveyor' => [RoleEnum::SURVEYOR, false],
    'resident owner' => [RoleEnum::RESIDENT, true],
]);

test('residents cannot update another resident\'s personal information', function (): void {
    $owner = User::factory()->resident()->create();
    $resident = User::factory()->resident()->create();
    $personalInformation = PersonalInformation::factory()->for($owner)->create();

    $response = $this->actingAs($resident)
        ->put(route('users.personal-information.update', $personalInformation), [
            'first_name' => 'Changed',
        ]);

    $response->assertForbidden();
    $this->assertDatabaseHas('personal_information', [
        'id' => $personalInformation->id,
        'first_name' => $personalInformation->first_name,
    ]);
});

test('personal information updates require authentication', function (): void {
    $owner = User::factory()->resident()->create();
    $personalInformation = PersonalInformation::factory()->for($owner)->create();

    $response = $this->put(
        route('users.personal-information.update', $personalInformation),
        [],
    );

    $response->assertRedirect('/login');
});

test('personal information updates validate all editable values', function (): void {
    $owner = User::factory()->resident()->create();
    $personalInformation = PersonalInformation::factory()->for($owner)->create();

    $response = $this->actingAs($owner)
        ->from(route('users.personal-information.edit', $personalInformation))
        ->put(route('users.personal-information.update', $personalInformation), [
            'first_name' => 'Changed',
            'middle_name' => '',
            'last_name' => 'Santos',
            'suffix' => '',
            'blood_type' => '',
            'gender' => 'unknown',
            'age' => -1,
            'birthdate' => '2100-01-01',
            'phone_number' => '09171234567',
            'email' => 'invalid',
        ]);

    $response->assertSessionHasErrors(['gender', 'age', 'birthdate', 'email']);
    $this->assertDatabaseHas('personal_information', [
        'id' => $personalInformation->id,
        'first_name' => $personalInformation->first_name,
    ]);
});

test('personal information requests reject negative ages and accept zero', function (
    string $requestClass,
): void {
    $rules = (new $requestClass)->rules();
    $validData = $requestClass === UpdatePersonalInformationRequest::class
        ? [
            'first_name' => 'Ana',
            'middle_name' => null,
            'last_name' => 'Santos',
            'suffix' => null,
            'blood_type' => null,
            'gender' => 'female',
            'birthdate' => '1990-04-12',
            'phone_number' => '09171234567',
            'email' => 'ana@example.test',
        ]
        : [];

    expect(Validator::make([...$validData, 'age' => '-1'], $rules)->fails())->toBeTrue()
        ->and(Validator::make([...$validData, 'age' => '0'], $rules)->passes())->toBeTrue();
})->with([
    'store' => [StorePersonalInformationRequest::class],
    'update' => [UpdatePersonalInformationRequest::class],
]);

test('personal information policies enforce role and owner access', function (
    RoleEnum $role,
    bool $isOwner,
    bool $canView,
    bool $canUpdate,
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

    expect(Gate::forUser($viewer)->allows('view', $personalInformation))->toBe($canView)
        ->and(Gate::forUser($viewer)->allows('update', $personalInformation))->toBe($canUpdate);
})->with([
    'admin' => [RoleEnum::ADMIN, false, true, true],
    'surveyor' => [RoleEnum::SURVEYOR, false, true, true],
    'resident owner' => [RoleEnum::RESIDENT, true, true, true],
    'other resident' => [RoleEnum::RESIDENT, false, false, false],
]);

test('only admins and surveyors can update household and barangay records', function (
    RoleEnum $role,
    bool $canUpdate,
): void {
    $user = User::factory()->create(['role' => $role]);
    $household = Household::factory()->create();
    $barangay = Barangay::factory()->create();
    $gate = Gate::forUser($user);

    expect($gate->allows('update', $household))->toBe($canUpdate)
        ->and($gate->allows('update', $barangay))->toBe($canUpdate);
})->with([
    'admin' => [RoleEnum::ADMIN, true],
    'surveyor' => [RoleEnum::SURVEYOR, true],
    'resident' => [RoleEnum::RESIDENT, false],
]);
