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
                'firstname'      => 'Admin',
                'lastname'       => 'Admin',
                'phone_number'      => '12345678',
                'email'          => 'admin@admin.com',
                'password'       => Hash::make('somesecretpassword'),
                'remember_token' => null,
                'created_at'     => '2021-07-19 15:31:45',
                'updated_at'     => '2021-07-19 15:31:45',
                'role'           => 'admin',
            ],

            [
                'firstname'      => 'John',
                'lastname'       => 'Doe',
                'phone_number'      => '0011223344',
                'email'          => 'johndoe@test.com',
                'password'       => Hash::make('password'),
                'remember_token' => null,
                'created_at'     => '2021-07-19 15:31:45',
                'updated_at'     => '2021-07-19 15:31:45',
                'role'           => 'guard',
            ],

            [
                'firstname'      => 'Jane',
                'lastname'       => 'Doe',
                'phone_number'      => '1122334455',
                'email'          => 'janedoe@test.com',
                'password'       => Hash::make('password'),
                'remember_token' => null,
                'created_at'     => '2021-07-19 15:31:45',
                'updated_at'     => '2021-07-19 15:31:45',
                'role'           => 'guard',
            ],

            [
                'firstname'      => 'Shaka',
                'lastname'       => 'Voo',
                'phone_number'      => '2233445566',
                'email'          => 'shakavoo@test.com',
                'password'       => Hash::make('password'),
                'remember_token' => null,
                'created_at'     => '2021-07-19 15:31:45',
                'updated_at'     => '2021-07-19 15:31:45',
                'role'           => 'guard',
            ],
        ];

        User::insert($users);
    }
}
