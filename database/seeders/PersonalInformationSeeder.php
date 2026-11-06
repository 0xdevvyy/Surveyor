<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\PersonalInformation;
use App\Models\User;
use Illuminate\Database\Seeder;

class PersonalInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residentsWithoutPersonalInformation = User::query()
            ->where('role', RoleEnum::RESIDENT->value)
            ->whereDoesntHave('personalInformation')
            ->get();

        foreach ($residentsWithoutPersonalInformation as $resident) {
            PersonalInformation::factory()
                ->for($resident)
                ->create(['email' => $resident->email]);
        }
    }
}
