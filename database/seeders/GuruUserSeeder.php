<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'guru@sekolah.test'],
            [
                'name' => 'Guru Utama',
                'password' => Hash::make('password123'),
            ]
        );

        $user->assignRole('guru');
    }
}
