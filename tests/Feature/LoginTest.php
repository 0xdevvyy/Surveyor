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
