<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Skip header
        $rows->shift();

        foreach ($rows as $row) {
            $role = strtolower(trim($row[0]));

            $user = User::updateOrCreate(
                ['email' => $row[2]],
                [
                    'name' => $row[1],
                    'email_orangtua' => $row[3] ?? null,
                    'nisn' => $row[4] ?? null,
                    'kelas' => $row[5] ?? null,
                    'jurusan' => $row[6] ?? null,
                    'password' => Hash::make($row[4]??'padalarang123'),
                    'no_hp' => $row[7] ?? null, // ✅ baru
                    'no_hp_orangtua' => $row[8] ?? null, // ✅ baru
                ]
            );

            if (!$user->hasRole($role)) {
                $user->syncRoles([$role]);
            }
        }
    }
}
