<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'ten' => 'admin',
                'sdt' => '12345678',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$E2dxQ9kJvvsEQRrqblLS7eqWF7ZHraD.bdzpLTQ3BFeBhz9No2eDu',
                'password_text' => '12345678',
                'chuc_vu' => '1',
            ],
            [
                'ten' => 'admin2',
                'sdt' => '123456789',
                'email' => 'admin2@gmail.com',
                'password' => '$2y$10$E2dxQ9kJvvsEQRrqblLS7eqWF7ZHraD.bdzpLTQ3BFeBhz9No2eDu',
                'password_text' => '12345678',
                'chuc_vu' => '1',
            ],
        ]);
    }
}
