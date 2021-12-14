<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Log;
use App\Models\Scan;
use App\Models\Issue;

class ShiftCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shift:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for on-time clock in';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = Carbon::now()->subMinutes(15);
        $now = Carbon::now();

        $shift = Scan::where('sector', 'TCS000201')->whereBetween('created_at', [$now, $start])->first();
        // $shift = Scan::where('sector', 'TCS000201')->first();
        $this->info($shift);
        if($shift == null)
        {
            $issue = new Issue;
            $issue->phone_number = 000;
            $issue->first_name = "Admin";
            $issue->title = "Delayed Clock In";
            $issue->issueLocation = 'Clock In';
            $issue->details = "No clock in was performed by a guard at Langata at the correct shift start";
            $success = $issue->save();
            $this->info($success);
        }

        $shift = Scan::where('sector', 'TCS00101')->whereBetween('created_at', [$now, $start])->first();
        // $shift = Scan::where('sector', 'TCS00101')->first();
        $this->info($shift);
        if($shift == null)
        {
            $issue = new Issue;
            $issue->phone_number = 000;
            $issue->first_name = "Admin";
            $issue->title = "Delayed Clock In";
            $issue->issueLocation = 'Clock In';
            $issue->details = "No clock in was performed by a guard at Baraka at the correct shift start";
            $success = $issue->save();
            $this->info($success);
        }
    }
}
