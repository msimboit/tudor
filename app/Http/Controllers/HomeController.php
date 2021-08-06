<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DateTime;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user()->id_number;
        $current_time = Carbon\Carbon::now();

        if(Auth::user()->role == 'guard')
        {

            $last_clock_in = DB::table('scans')
            ->select('created_at')
            ->where('guard_id', '=', $user)
            ->where('sector_name', '=', 'Clocking In')
            ->orderBy('created_at', 'desc')
            ->first();
        
                if($last_clock_in == null){
                    return view('home', ['current_time' => $current_time->toDateString()]);
                }
                else {

                    $date = new DateTime($last_clock_in->created_at);
                    $now = new DateTime();

                    $diff = $date->diff($now)->format("%d days, %h hours and %i minutes");

                    $last_scan = DB::table('scans')
                        ->select('sector_name')
                        ->where('guard_id', '=', $user)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    

                    if($diff < "0 days, 12 hours and 0 minutes" && $last_scan != 'Clocking Out') {
                        return redirect()->route('patrol');
                    }

                    return view('home', ['current_time' => $current_time->toDateString()]);
                }
        }

        return view('home', ['current_time' => $current_time->toDateString()]);
    }
    
}
