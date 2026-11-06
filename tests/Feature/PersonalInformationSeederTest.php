<?php

use App\Models\PersonalInformation;
use App\Models\User;
use Database\Seeders\PersonalInformationSeeder;

test('seeds profiles for residents who do not already have one', function (): void {
    $residentWithProfile = User::factory()->resident()->create();
    $residentWithoutProfile = User::factory()->resident()->create();
    $surveyor = User::factory()->surveyor()->create();

    PersonalInformation::factory()
        ->for($residentWithProfile)
        ->create();

    $seeder = new PersonalInformationSeeder;
    $seeder->run();
    $seeder->run();

    $this->assertDatabaseCount('personal_information', 2);
    $this->assertDatabaseHas('personal_information', [
        'user_id' => $residentWithoutProfile->id,
        'email' => $residentWithoutProfile->email,
    ]);
    $this->assertDatabaseMissing('personal_information', [
        'user_id' => $surveyor->id,
    ]);
});
