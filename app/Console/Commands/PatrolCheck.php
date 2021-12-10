<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class PatrolCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patrol:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Confirm all check points were scanned';

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
        $start = Carbon::now()->subMinutes(60);
        $now = Carbon::now();

        /**
         * Check if all points in Langata were scanned within the hour
         */
        $langata_patrol_count = count(Scan::where('location', 'langata')->whereBetween('created_at', [$start, $now])->get());
        $this->info($langata_patrol_count);
        if($langata_patrol_count < 17)
        {
            $issue = new Issue;
            $issue->phone_number = 000;
            $issue->first_name = "Admin";
            $issue->title = "Patrol Count";
            $issue->issueLocation = 'Langata';
            $issue->details = "Not all points were scanned at the Langata site!";
            $success = $issue->save();
            $this->info($success);
        }

        /**
         * Check if all points in Baraka were scanned within the hour
         */
        $baraka_patrol_count = count(Scan::where('location', 'baraka')->whereBetween('created_at', [$start, $now])->get());
        if($baraka_patrol_count < 4)
        {
            $issue = new Issue;
            $issue->phone_number = 000;
            $issue->first_name = "Admin";
            $issue->title = "Patrol Count";
            $issue->issueLocation = 'Baraka';
            $issue->details = "Not all points were scanned at the Baraka site!";
            $success = $issue->save();
            $this->info($success);
        }
    }
}
