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
        $user = Auth::user()->phone_number;
        $current_time = Carbon\Carbon::now();

        $roles = ['guard', 'management', 'operations', 'control', 'production'];

        if(in_array( (Auth::user()->role), $roles ))
        {

            $last_clock_in = DB::table('scans')
            ->select('created_at')
            ->where('phone_number', '=', $user)
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
                        ->where('phone_number', '=', $user)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    

                    if($diff < "0 days, 12 hours and 0 minutes" && $last_scan != 'Clocking Out' && Auth::user()->role === 'guard') {
                        return redirect()->route('patrol');
                    }

                    if($diff < "0 days, 12 hours and 0 minutes" && $last_scan != 'Clocking Out' && Auth::user()->role !== 'guard') {
                        return redirect()->route('patrol');
                    }

                    return view('home', ['current_time' => $current_time->toDateString()]);
                }
        }

        return view('home', ['current_time' => $current_time->toDateString()]);
    }
    
}
