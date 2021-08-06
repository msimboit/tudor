<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use DB;
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
        $users = [
            [
                'id'             => 1,
                'firstname'      => 'Admin',
                'lastname'       => 'Admin',
                'id_number'      => '12345678',
                'email'          => 'admin@admin.com',
                'password'       => Hash::make('somesecretpassword'),
                'remember_token' => null,
                'created_at'     => '2021-07-19 15:31:45',
                'updated_at'     => '2021-07-19 15:31:45',
                'role'           => 'admin',
            ],
        ];

        User::insert($users);
    }
}
