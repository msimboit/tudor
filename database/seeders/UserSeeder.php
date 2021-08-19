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

            [
                'firstname'      => 'Philip',
                'lastname'       => 'Wawazi',
                'phone_number'      => '0700682679',
                'email'          => 'wawaziphil@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'production',
            ],

            [
                'firstname'      => 'Trevor',
                'lastname'       => 'Baraka',
                'phone_number'      => '0792003726',
                'email'          => 'trevorbaraka4@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'production',
            ],

            [
                'firstname'      => 'Bernard',
                'lastname'       => 'Nyagechi',
                'phone_number'      => '0742861210',
                'email'          => 'bmnyagechi@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'operations',
            ],

            [
                'firstname'      => 'Dennis',
                'lastname'       => 'Karei',
                'phone_number'      => '0715006690',
                'email'          => 'Dennis.Karei@msimboit.net',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'management',
            ],

            [
                'firstname'      => 'Joseph',
                'lastname'       => 'Omollo',
                'phone_number'      => '0727200231',
                'email'          => 'jromosh@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'operations',
            ],

            [
                'firstname'      => 'Isaac',
                'lastname'       => 'Parmeres',
                'phone_number'      => '0705406700',
                'email'          => 'iparmeres@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'operations',
            ],

            [
                'firstname'      => 'Robert',
                'lastname'       => 'Aboka',
                'phone_number'      => '0729901217',
                'email'          => 'robert.aboka@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'management',
            ],

            [
                'firstname'      => 'James',
                'lastname'       => 'Nyabera',
                'phone_number'      => '0723862924',
                'email'          => 'jamesnyabera1@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'production',
            ],

            [
                'firstname'      => 'Michael',
                'lastname'       => 'Mugo',
                'phone_number'      => '0727343651',
                'email'          => 'mugomuchiri@yahoo.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'management',
            ],

            [
                'firstname'      => 'Lauren',
                'lastname'       => 'Kabanyana',
                'phone_number'      => '0703989127',
                'email'          => 'laurenkabanyana@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'production',
            ],

            [
                'firstname'      => 'John',
                'lastname'       => 'Omollo',
                'phone_number'      => '0718330262',
                'email'          => 'jcomollo@yahoo.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'management',
            ],

            [
                'firstname'      => 'Abraham',
                'lastname'       => 'Nyabera',
                'phone_number'      => '0704618977',
                'email'          => 'abnyabera@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'management',
            ],

            [
                'firstname'      => 'Jack',
                'lastname'       => 'Seddah',
                'phone_number'      => '0724055873',
                'email'          => 'jack.seddah@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'production',
            ],

            [
                'firstname'      => 'Dan',
                'lastname'       => 'Ogonji',
                'phone_number'      => '0715804335',
                'email'          => 'danogonji@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'production',
            ],

            [
                'firstname'      => 'Clinton',
                'lastname'       => 'Kokan',
                'phone_number'      => '0769488011',
                'email'          => 'clintonkokan@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'operations',
            ],

            [
                'firstname'      => 'Allan',
                'lastname'       => 'Oguk',
                'phone_number'      => '0769766585',
                'email'          => 'Allanoguk@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'operations',
            ],

            [
                'firstname'      => 'Cynthia',
                'lastname'       => 'Anjeline',
                'phone_number'      => '0739155799',
                'email'          => 'cynthiaanjeline@gmail.com',
                'password'       => Hash::make('12345678'),
                'remember_token' => null,
                'created_at'     => '2021-08-19 15:31:45',
                'updated_at'     => '2021-08-19 15:31:45',
                'role'           => 'production',
            ],
        ];

        User::insert($users);
    }
}
