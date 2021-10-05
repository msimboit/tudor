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
            'name' => 'Clock In',
            'code' => 'TCS000201',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Site Office',
            'code' => 'TCS000202',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block A',
            'code' => 'TCS000203',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block A Top',
            'code' => 'TCS000204',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block A Front',
            'code' => 'TCS000205',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block A Back',
            'code' => 'TCS000206',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block B',
            'code' => 'TCS000207',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block B Top',
            'code' => 'TCS000208',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block B Front',
            'code' => 'TCS000209',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block B Back',
            'code' => 'TCS000210',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block C',
            'code' => 'TCS000211',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block C Top',
            'code' => 'TCS000212',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block C Front',
            'code' => 'TCS000213',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block C Back',
            'code' => 'TCS000214',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Left',
            'code' => 'TCS000215',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Right',
            'code' => 'TCS000216',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Back',
            'code' => 'TCS000217',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock Out',
            'code' => 'TCS000218',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Security Office',
            'code' => 'TCS000219',
            'location'=> 'langata'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock In - B',
            'code' => 'TCS00101',
            'location'=> 'baraka'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Security Office - B',
            'code' => 'TCS00102',
            'location'=> 'baraka'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block 1 - B',
            'code' => 'TCS00103',
            'location'=> 'baraka'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Block 2 - B',
            'code' => 'TCS00104',
            'location'=> 'baraka'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Open Area - B',
            'code' => 'TCS00105',
            'location'=> 'baraka'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock Out - B',
            'code' => 'TCS00106',
            'location'=> 'baraka'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock In - Allimex Ground Floor',
            'code' => 'ALPGF01CI',
            'location'=> 'allimex'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock Out - Allimex Ground Floor',
            'code' => 'ALPGF01CO',
            'location'=> 'allimex'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock In - Allimex Second Floor',
            'code' => 'ALP2F01CI',
            'location'=> 'allimex'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock Out - Allimex Second Floor',
            'code' => 'ALP2F01CO',
            'location'=> 'allimex'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock In - Allimex Third Floor',
            'code' => 'ALP3F01CI',
            'location'=> 'allimex'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock Out - Allimex Third Floor',
            'code' => 'ALP3F01CO',
            'location'=> 'allimex'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock In - Allimex Fifth Floor',
            'code' => 'ALP5F01CI',
            'location'=> 'allimex'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock Out - Allimex Fifth Floor',
            'code' => 'ALP5F01CO',
            'location'=> 'allimex'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock In - Allimex Fifth Floor',
            'code' => 'ALP5F02CI',
            'location'=> 'allimex'
        ]);

        DB::table('qr_codes')->insert([
            'name' => 'Clock Out - Allimex Fifth Floor',
            'code' => 'ALP5F02CO',
            'location'=> 'allimex'
        ]);
    }
}
