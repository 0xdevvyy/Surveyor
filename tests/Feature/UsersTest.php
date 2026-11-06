<?php

use App\Enum\RoleEnum;
use App\Models\Barangay;
use App\Models\Household;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('admin can list every non-admin user', function (): void {
    $admin = User::factory()->admin()->create();
    $resident = User::factory()->resident()->create([
        'name' => 'A Resident',
    ]);
    $surveyor = User::factory()->surveyor()->create([
        'name' => 'A Surveyor',
    ]);

    $response = $this->actingAs($admin)->get(route('auth.admin.users.index'));

    $response->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Index')
            ->has('users.data', 2)
            ->where('users.total', 2)
            ->where('users.data.0.id', $resident->id)
            ->where('users.data.0.name', 'A Resident')
            ->has('users.data.0.emailVerifiedAt')
            ->where('users.data.1.id', $surveyor->id)
            ->where('filters.role', null)
    );
});

test('admin can filter users by role', function (
    string $role,
    RoleEnum $includedRole,
    RoleEnum $excludedRole,
): void {
    $admin = User::factory()->admin()->create();
    $includedUser = User::factory()->create([
        'role' => $includedRole,
    ]);
    User::factory()->create([
        'role' => $excludedRole,
    ]);

    $response = $this->actingAs($admin)->get(route('auth.admin.users.index', [
        'role' => $role,
    ]));

    $response->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Index')
            ->has('users.data', 1)
            ->where('users.total', 1)
            ->where('users.data.0.id', $includedUser->id)
            ->where('filters.role', $role)
    );
})->with([
    'surveyors' => ['surveyor', RoleEnum::SURVEYOR, RoleEnum::RESIDENT],
    'residents' => ['resident', RoleEnum::RESIDENT, RoleEnum::SURVEYOR],
]);

test('admin can search users by name, barangay, or household number', function (
    string $search,
): void {
    $admin = User::factory()->admin()->create();
    $resident = User::factory()->resident()->create([
        'name' => 'Marisol Santos',
    ]);
    $barangay = Barangay::factory()->create([
        'name' => 'Santa Rita',
    ]);
    Household::factory()
        ->for($resident)
        ->for($barangay)
        ->create([
            'household_number' => 'HH-742',
        ]);

    $unmatchedResident = User::factory()->resident()->create([
        'name' => 'Other Resident',
    ]);
    Household::factory()
        ->for($unmatchedResident)
        ->for(Barangay::factory()->create(['name' => 'Bueno']))
        ->create([
            'household_number' => 'HH-318',
        ]);

    $response = $this->actingAs($admin)->get(route('auth.admin.users.index', [
        'role' => 'resident',
        'search' => $search,
    ]));

    $response->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Index')
            ->has('users.data', 1)
            ->where('users.total', 1)
            ->where('users.data.0.id', $resident->id)
            ->where('users.data.0.households.0.householdNumber', 'HH-742')
            ->where('users.data.0.households.0.barangay', 'Santa Rita')
            ->where('filters.search', $search)
    );
})->with([
    'resident name' => 'Marisol',
    'barangay name' => 'Santa Rita',
    'household number' => 'HH-742',
]);

test('non-admin users cannot access the users list', function (): void {
    $surveyor = User::factory()->surveyor()->create();

    $response = $this->actingAs($surveyor)->get(route('auth.admin.users.index'));

    $response->assertNotFound();
});

test('users list requires authentication', function (): void {
    $response = $this->get(route('auth.admin.users.index'));

    $response->assertRedirect('/login');
});
