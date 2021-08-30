<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Scan;
use App\Models\Shift;
use Carbon\Carbon;
use DateTime;

class ScannerController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = ['guard', 'management', 'operations', 'control', 'production'];
        
        if( in_array( (Auth::user()->role), $roles ) )
        {
            $user = Auth::user();
            return view('scanner', ['user' => $user]);
        }
        
        return redirect()->route('home');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'sector' => 'required',
            'sector_name' => 'required',
        ]);

        // $img =  $request->get('image');
        // $folderPath = "uploads/";
        // $image_parts = explode(";base64,", $img);

        // foreach ($image_parts as $key => $image){
        //     $image_base64 = base64_decode($image);
        // }

        // $fileName = uniqid() . '.png';
        // $file = $folderPath . $fileName;
        // file_put_contents($file, $image_base64);

        // Info::create([
        //     'name' => request('name'),
        //     'age' => request('age'),
        //     'image' => $fileName,
        // ]);


        $last_clock_in = DB::table('scans')
        ->select('created_at')
        ->where('phone_number', '=', $user->phone_number)
        ->where('sector_name', '=', 'Clocking In')
        ->orderBy('created_at', 'desc')
        ->first();

        $last_scanned_site = DB::table('scans')
            ->where('phone_number', '=', $user->phone_number)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if($last_clock_in == null){
            $user = Auth::user();
            $current_time = Carbon::now();

            $scan= new Scan;
            $scan->phone_number = $user->phone_number;
            $scan->first_name = $user->firstname;
            $scan->latitude = $request->latitude;
            $scan->longitude = $request->longitude;
            $scan->sector = $request->sector;
            $scan->sector_name = $request->sector_name;
            $scan->time = $request->scan_time;
            $success = $scan->save();

            $shift = new Shift;
            $shift->phone_number = $user->phone_number;
            $shift->first_name = $user->firstname;
            $shift->last_name = $user->lastname;
            $shift->role = $user->role;
            $shift->clockin = $scan->created_at;
            $success2 = $shift->save();
            
            if(Auth::user()->role === 'guard')
            {
                return view('patrol', ['current_time' => $current_time->toDateString()])->with('success', 'Scan Successful!');
            }

            return redirect()->route('home');
        }

        $date = new DateTime($last_clock_in->created_at);
        $now = new DateTime();
        
        $diff = $date->diff($now)->format("%d days, %h hours and %i minutes");

        if($diff > "0 days, 12 hours and 0 minutes" && ($request->sector_name) != 'Clocking In') {

            session()->flush();
            return redirect()->route('welcome');
        }
        
        if($diff < "0 days, 12 hours and 0 minutes" && ($request->sector_name) == 'Clocking In' && Auth::user()->role === 'guard') {
            return redirect()->route('patrol');
        }

        if($diff < "0 days, 12 hours and 0 minutes" && ($request->sector_name) == 'Clocking In' && Auth::user()->role !== 'guard') {
            return redirect()->route('home');
        }
        

        $current_time = Carbon::now();

        $scan= new Scan;
        $scan->phone_number = $user->phone_number;
        $scan->first_name = $user->firstname;
        $scan->latitude = $request->latitude;
        $scan->longitude = $request->longitude;
        $scan->sector = $request->sector;
        $scan->sector_name = $request->sector_name;
        $scan->time = $request->scan_time;
        $success = $scan->save();

        if($scan->sector_name == 'Clocking In' && $last_scanned_site->sector_name != 'Clocking Out' ) {
            $in = new DateTime($last_clock_in->created_at);
            $out = new DateTime($scan->created_at);
            $duration = $out->diff($in)->format("%d days, %h hours and %i minutes");

            $shift = DB::table('shifts')
                    ->where('phone_number', ($user->phone_number))
                    ->where('clockin', ($last_clock_in->created_at))
                    ->update([
                        'clockout' => $scan->created_at,
                        'shift_duration' => $duration
                        ]);

            $shift = new Shift;
            $shift->phone_number = $user->phone_number;
            $shift->first_name = $user->firstname;
            $shift->last_name = $user->lastname;
            $shift->role = $user->role;
            $shift->clockin = $scan->created_at;
            $success2 = $shift->save();
        }

        if($scan->sector_name == 'Clocking Out') {
            $in = new DateTime($last_clock_in->created_at);
            $out = new DateTime($scan->created_at);
            $duration = $out->diff($in)->format("%d days, %h hours and %i minutes");

            $shift = DB::table('shifts')
                    ->where('phone_number', ($user->phone_number))
                    ->where('clockin', ($last_clock_in->created_at))
                    ->update([
                        'clockout' => $scan->created_at,
                        'shift_duration' => $duration
                        ]);
        }

        if($scan->sector_name == 'Clocking Out') {
            session()->flush();
            return redirect()->route('welcome');
        }

        if(Auth::user()->role === 'guard'){
        return view('patrol', ['current_time' => $current_time->toDateString()])->with('success', 'Scan Successful!');
        }

        return view('welcome');
    }

    /**
     * Find Last System Interactions i.e, when was the last clock in prior to last scan
     *
     * @return \Illuminate\Http\Response
     */
    public function last_interactions()
    {
        $user = Auth::user();

        $last_clock_in = DB::table('scans')
        ->select('created_at')
        ->where('first_name', '=', $user->firstname)
        ->where('sector_name', '=', 'Clocking In')
        ->orderBy('created_at', 'desc')
        ->first();
        //dd($last_clock_in);

        $last_clock_in = DB::table('scans')
        ->select('created_at')
        ->where('first_name', '=', $user->firstname)
        ->where('sector_name', '=', 'Clocking In')
        ->orderBy('created_at', 'desc')
        ->first();

        $last_scan = DB::table('scans')
            ->select('created_at')
            ->where('first_name', '=', $user->firstname)
            ->orderBy('created_at', 'desc')
            ->first();
    
        $last_scanned_site = DB::table('scans')
            ->where('first_name', '=', $user->firstname)
            ->orderBy('created_at', 'asc')
            ->first();

        $last_scan = new DateTime($last_scan->created_at);
        $last_clock_in = new DateTime($last_clock_in->created_at);

        $diff = $last_scan->diff($last_clock_in);
        //$hours_worked = explode( '.', $diff );
        
        dd ($diff);
    }

    /**
     * Keep track of clock ins
     *
     * @return \Illuminate\Http\Response
     */
    public function clockin()
    {
        $roles = ['guard', 'management', 'operations', 'control', 'production'];
        
        if( in_array( (Auth::user()->role), $roles ) )
        {
            $user = Auth::user();

            $last_scanned_site = DB::table('scans')
                ->where('phone_number', '=', $user->phone_number)
                ->orderBy('created_at', 'desc')
                ->first();
            
            /*First Time User Check */
            if($last_scanned_site == null) {
                return view('scanner', ['user' => $user]);
                }
            
            /*Check if the usual user had clocked out before */ 
            if($last_scanned_site->sector_name != 'Clocking Out') {
            $scan= new Scan;
            $scan->phone_number = $user->phone_number;
            $scan->first_name = $user->firstname;
            $scan->latitude = $last_scanned_site->latitude;
            $scan->longitude = $last_scanned_site->longitude;
            $scan->sector_name = 'Clocking Out';
            $scan->time = $last_scanned_site->time;
            $scan->created_at = $last_scanned_site->created_at;
            $scan->updated_at = $last_scanned_site->updated_at;
            $scan->save();
            }

        }
        return view('scanner', ['user' => $user]);
    }
    
    /**
     * Display specific guards scanned areas during that shift
     * 
     * @return \Illuminate\Http\Response
     */
    public function scanned_areas()
    {
        $user = Auth::user();
        $current_time = Carbon::now();

        $last_clock_in = DB::table('scans')
        ->select('created_at')
        ->where('phone_number', '=', $user->phone_number)
        ->where('sector_name', '=', 'Clocking In')
        ->orderBy('created_at', 'desc')
        ->first();

        if($last_clock_in == null){
            return redirect()->route('home');
        }
        else{
            $last_clock_in = new DateTime($last_clock_in->created_at);
            
            $scanned_areas = DB::table('scans')
            ->select('sector_name')
            ->where('phone_number', '=', $user->phone_number)
            ->where('sector_name', '!=', 'Clockin Out')
            ->where('sector_name', '!=', 'Clockin Out')
            ->where('created_at', '>', $last_clock_in)
            ->orderBy('created_at', 'desc')
            ->get();
            
            return view('scanned_areas', ['current_time' => $current_time], compact('scanned_areas'));
        }

    }
}
