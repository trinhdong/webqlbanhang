<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'super_admin',
            'email' => 'super_admin@example.com',
            'password' => Hash::make('password'),
            'role' => SUPER_ADMIN,
            'is_admin' => 1,
        ]);
    }
}
