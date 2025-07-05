<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('settings')->insert([
    ['key' => 'school_name', 'value' => 'SMA Negeri 1 Contoh'],
    ['key' => 'school_address', 'value' => 'Jl. Pendidikan No. 1'],
    ['key' => 'mail_host', 'value' => 'smtp.gmail.com'],
    ['key' => 'mail_port', 'value' => '587'],
    ['key' => 'mail_username', 'value' => ''],
    ['key' => 'mail_password', 'value' => ''],
    ['key' => 'mail_encryption', 'value' => 'tls'],
    ['key' => 'mail_from_address', 'value' => 'noreply@domain.com'],
    ['key' => 'mail_from_name', 'value' => 'EZIN Sekolah'],
]);

    }
}
