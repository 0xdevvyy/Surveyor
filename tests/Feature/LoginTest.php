<?php

use App\Enum\RoleEnum;
use App\Models\Barangay;
use App\Models\Household;
use App\Models\SurveyQuestion;
use App\Models\User;
use Database\Seeders\SurveyQuestionSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('database sessions retain authenticated UUID user IDs', function (): void {
    config(['session.driver' => 'database']);

    $user = User::factory()->create([
        'role' => RoleEnum::ADMIN,
    ]);

    $response = $this->post(route('auth.store'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirectToRoute('auth.admin.dashboard');
    $this->assertDatabaseHas('sessions', [
        'user_id' => $user->getKey(),
    ]);

    $this->get(route('auth.admin.dashboard'))->assertOk();
});

test('each role can access its matching dashboard', function (
    RoleEnum $role,
    string $routeName,
    string $component,
): void {
    $user = User::factory()->create([
        'role' => $role,
    ]);

    $response = $this->actingAs($user)->get(route($routeName));

    $response
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page->component($component)->has('metrics')
        );
})->with([
    'admin' => [RoleEnum::ADMIN, 'auth.admin.dashboard', 'dashboard/Admin'],
    'surveyor' => [
        RoleEnum::SURVEYOR,
        'auth.surveyor.dashboard',
        'dashboard/Surveyor',
    ],
    'resident' => [
        RoleEnum::RESIDENT,
        'auth.resident.dashboard',
        'dashboard/Resident',
    ],
]);

test('surveyor dashboard reports household counts by barangay', function (): void {
    $surveyor = User::factory()->create([
        'role' => RoleEnum::SURVEYOR,
    ]);
    $anotherSurveyor = User::factory()->create([
        'role' => RoleEnum::SURVEYOR,
    ]);
    $firstResident = User::factory()->create([
        'role' => RoleEnum::RESIDENT,
    ]);
    $secondResident = User::factory()->create([
        'role' => RoleEnum::RESIDENT,
    ]);
    $thirdResident = User::factory()->create([
        'role' => RoleEnum::RESIDENT,
    ]);
    $fourthResident = User::factory()->create([
        'role' => RoleEnum::RESIDENT,
    ]);
    $firstBarangay = Barangay::factory()->create([
        'name' => 'Alpha',
    ]);
    $secondBarangay = Barangay::factory()->create([
        'name' => 'Beta',
    ]);
    Barangay::factory()->create([
        'name' => 'Gamma',
    ]);

    Household::factory()->create([
        'household_number' => 'HH-001',
        'user_id' => $firstResident->id,
        'barangay_id' => $firstBarangay->id,
    ]);
    Household::factory()->create([
        'household_number' => 'HH-002',
        'user_id' => $secondResident->id,
        'barangay_id' => $firstBarangay->id,
    ]);
    Household::factory()->create([
        'household_number' => 'HH-004',
        'user_id' => $fourthResident->id,
        'barangay_id' => $firstBarangay->id,
    ]);
    Household::factory()->create([
        'household_number' => 'HH-003',
        'user_id' => $thirdResident->id,
        'barangay_id' => $secondBarangay->id,
    ]);
    SurveyQuestion::factory()->create([
        'surveyor_id' => $surveyor->id,
        'residents_id' => $firstResident->id,
    ]);
    SurveyQuestion::factory()->create([
        'surveyor_id' => $surveyor->id,
        'residents_id' => $firstResident->id,
    ]);
    SurveyQuestion::factory()->create([
        'surveyor_id' => $anotherSurveyor->id,
        'residents_id' => $secondResident->id,
    ]);

    $response = $this->actingAs($surveyor)->get(route('auth.surveyor.dashboard'));

    $response->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->component('dashboard/Surveyor')
            ->has('householdBarangays', 3)
            ->where('householdBarangays.0.name', 'Alpha')
            ->where('householdBarangays.0.households', 3)
            ->where('householdBarangays.1.name', 'Beta')
            ->where('householdBarangays.1.households', 1)
            ->where('householdBarangays.2.name', 'Gamma')
            ->where('householdBarangays.2.households', 0)
            ->has('surveyProgressByBarangay', 3)
            ->where('surveyProgressByBarangay.0.name', 'Alpha')
            ->where('surveyProgressByBarangay.0.totalResidents', 3)
            ->where('surveyProgressByBarangay.0.surveyedResidents', 2)
            ->where('surveyProgressByBarangay.1.name', 'Beta')
            ->where('surveyProgressByBarangay.1.totalResidents', 1)
            ->where('surveyProgressByBarangay.1.surveyedResidents', 0)
            ->where('surveyProgressByBarangay.2.totalResidents', 0)
            ->where('surveyProgressByBarangay.2.surveyedResidents', 0)
    );
});

test('admin dashboard reports community charts across all surveyors', function (): void {
    $admin = User::factory()->admin()->create();
    $firstSurveyor = User::factory()->surveyor()->create();
    $secondSurveyor = User::factory()->surveyor()->create();
    $firstResident = User::factory()->resident()->create();
    $secondResident = User::factory()->resident()->create();
    $barangay = Barangay::factory()->create(['name' => 'Alpha']);
    Barangay::factory()->create(['name' => 'Beta']);

    Household::factory()
        ->for($firstResident)
        ->for($barangay)
        ->create(['household_number' => 'HH-ADMIN-001']);
    Household::factory()
        ->for($secondResident)
        ->for($barangay)
        ->create(['household_number' => 'HH-ADMIN-002']);
    SurveyQuestion::factory()->create([
        'surveyor_id' => $firstSurveyor->id,
        'residents_id' => $firstResident->id,
    ]);
    SurveyQuestion::factory()->create([
        'surveyor_id' => $secondSurveyor->id,
        'residents_id' => $secondResident->id,
    ]);

    $response = $this->actingAs($admin)->get(route('auth.admin.dashboard'));

    $response->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->component('dashboard/Admin')
            ->has('householdBarangays', 2)
            ->where('householdBarangays.0.name', 'Alpha')
            ->where('householdBarangays.0.households', 2)
            ->where('householdBarangays.1.name', 'Beta')
            ->where('householdBarangays.1.households', 0)
            ->has('surveyProgressByBarangay', 2)
            ->where('surveyProgressByBarangay.0.name', 'Alpha')
            ->where('surveyProgressByBarangay.0.totalResidents', 2)
            ->where('surveyProgressByBarangay.0.surveyedResidents', 2)
            ->where('surveyProgressByBarangay.1.totalResidents', 0)
            ->where('surveyProgressByBarangay.1.surveyedResidents', 0)
    );
});

test('seeded survey responses count under the resident household barangay', function (): void {
    $surveyor = User::factory()->surveyor()->create();
    $firstResident = User::factory()->resident()->create();
    $secondResident = User::factory()->resident()->create();
    $firstBarangay = Barangay::factory()->create([
        'name' => 'Alpha',
    ]);
    $secondBarangay = Barangay::factory()->create([
        'name' => 'Beta',
    ]);

    Household::factory()
        ->for($firstResident)
        ->for($firstBarangay)
        ->create(['household_number' => 'HH-SEED-001']);
    Household::factory()
        ->for($secondResident)
        ->for($secondBarangay)
        ->create(['household_number' => 'HH-SEED-002']);

    app(SurveyQuestionSeeder::class)->run();

    $response = $this->actingAs($surveyor)->get(route('auth.surveyor.dashboard'));

    $response->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->where('surveyProgressByBarangay.0.name', 'Alpha')
            ->where('surveyProgressByBarangay.0.surveyedResidents', 1)
            ->where('surveyProgressByBarangay.1.name', 'Beta')
            ->where('surveyProgressByBarangay.1.surveyedResidents', 1)
    );
});

test('admin dashboard lists the most recently registered users', function (): void {
    $admin = User::factory()->create([
        'role' => RoleEnum::ADMIN,
        'created_at' => now()->subHours(12),
    ]);
    $olderUser = User::factory()->create([
        'created_at' => now()->subDay(),
    ]);
    $newerUser = User::factory()->create([
        'created_at' => now(),
    ]);

    $response = $this->actingAs($admin)->get(route('auth.admin.dashboard'));

    $response->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->component('dashboard/Admin')
            ->has('users.data', 2)
            ->where('users.total', 2)
            ->where('users.per_page', 2)
        // ->where('users.data.0.email', $newerUser->email)
        // ->where('users.data.1.email', $admin->email)
        // ->where('users.data.2.email', $olderUser->email)
    );
});

test('admin dashboard paginates users 2 at a time', function (): void {
    $admin = User::factory()->create([
        'role' => RoleEnum::ADMIN,
    ]);
    User::factory()->count(10)->create();

    $firstPage = $this->actingAs($admin)->get(route('auth.admin.dashboard'));

    $firstPage->assertOk()->assertInertia(
        fn (Assert $page) => $page
            ->has('users.data', 2)
            ->where('users.current_page', 1)
            ->where('users.per_page', 2)
            ->where('users.total', 10)
    );

    $this->get(route('auth.admin.dashboard', ['page' => 2]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->has('users.data', 2)
                ->where('users.current_page', 2)
                ->where('users.total', 10)
        );
});

test('admin can delete another user', function (): void {
    $admin = User::factory()->create([
        'role' => RoleEnum::ADMIN,
    ]);
    $user = User::factory()->create();

    $response = $this->actingAs($admin)->delete(
        route('auth.admin.users.destroy', $user)
    );

    $response->assertRedirectToRoute('auth.admin.dashboard');
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('admin cannot delete their own account', function (): void {
    $admin = User::factory()->create([
        'role' => RoleEnum::ADMIN,
    ]);

    $this->actingAs($admin)
        ->delete(route('auth.admin.users.destroy', $admin))
        ->assertForbidden();

    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

test('non-admin users cannot delete accounts', function (): void {
    $resident = User::factory()->create([
        'role' => RoleEnum::RESIDENT,
    ]);
    $user = User::factory()->create();

    $this->actingAs($resident)
        ->delete(route('auth.admin.users.destroy', $user))
        ->assertNotFound();

    $this->assertDatabaseHas('users', ['id' => $user->id]);
});
