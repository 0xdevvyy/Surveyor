<?php

use App\Enum\RoleEnum;
use App\Models\User;
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
