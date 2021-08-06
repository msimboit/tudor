<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->insert([
            'guard_id' => 'Guard Id',
            'guard_name' => 'Guard Name',
            'clockin' => 'Clock In',
            'clockout' => 'Clock Out',
            'shift_duration' => 'Shift Duration',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }
}
