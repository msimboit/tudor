<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class QrCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('qr_codes')->insert([
            'name' => 'clock_in',
            'code' => 'TCS000201',
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'site_office',
            'code' => 'TCS000202',
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'block_c_top',
            'code' => 'TCS000212',
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'left',
            'code' => 'TCS000215',
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'right',
            'code' => 'TCS000216',
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'clock_out',
            'code' => 'TCS000218',
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'security_office',
            'code' => 'TCS000219',
        ]);
    }
}
