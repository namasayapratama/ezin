<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WorkstationUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'workstation@sekolah.test'],
            [
                'name' => 'Workstation 1',
                'password' => Hash::make('password123'),
            ]
        );

        $user->assignRole('workstation');
    }
}