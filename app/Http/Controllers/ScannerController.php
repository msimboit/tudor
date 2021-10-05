<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Scan;
use App\Models\Shift;
use App\Models\QrCode;
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
        //Check if they came from the clockin route and whether they are scanning clockin codes
        $url = url()->previous();
        if (str_contains($url, 'clockin')) {
            $scanning_of = $request->sector_name;
            if($scanning_of != 'Clocking In')
            {
                return redirect()->back()->with('alert', 'Please scan the right code!');
            }
        }

        $user = Auth::user();
        if(($request->latitude) == '' || ($request->longitude) == '')
        {
            return redirect()->back()->with('alert', 'Please Enable Your Location!');
        }

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
            $location = (QrCode::where('code', $request->sector)->select('location')->first())->toArray();

            $scan= new Scan;
            $scan->phone_number = $user->phone_number;
            $scan->first_name = $user->firstname;
            $scan->role = $user->role;
            $scan->latitude = $request->latitude;
            $scan->longitude = $request->longitude;
            $scan->sector = $request->sector;
            $scan->sector_name = $request->sector_name;
            $scan->time = $request->scan_time;
            $scan->location = $location['location'];
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

            return redirect()->route('home')->with('success', 'Scan Successful!');
        }

        $date = new DateTime($last_clock_in->created_at);
        $now = new DateTime();
        
        $diff = $date->diff($now)->format("%d days, %h hours and %i minutes");

        // if($diff > "0 days, 12 hours and 0 minutes" && ($request->sector_name) != 'Clocking In') {
        //     session()->flush();
        //     return redirect()->route('welcome');
        // }
        
        // if($diff < "0 days, 12 hours and 0 minutes" && ($request->sector_name) == 'Clocking In')
        // {
        //     return redirect()->route('patrol');
        // }

        $current_time = Carbon::now();

        $location = (QrCode::where('code', $request->sector)->select('location')->first())->toArray();

        $scan= new Scan;
        $scan->phone_number = $user->phone_number;
        $scan->first_name = $user->firstname;
        $scan->role = $user->role;
        $scan->latitude = $request->latitude;
        $scan->longitude = $request->longitude;
        $scan->sector = $request->sector;
        $scan->sector_name = $request->sector_name;
        $scan->time = $request->scan_time;
        $scan->location = $location['location'];
        $success = $scan->save();

        if($scan->sector_name == 'Clocking In')
        {
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

            // $shift = new Shift;
            // $shift->phone_number = $user->phone_number;
            // $shift->first_name = $user->firstname;
            // $shift->last_name = $user->lastname;
            // $shift->role = $user->role;
            // $shift->clockin = $scan->created_at;
            // $success2 = $shift->save();
        }

        if($scan->sector_name == 'Clocking Out') {
            session()->flush();
            $state = 'Clock Out Successful! Log back in when you come back to work';
            return redirect()->route('welcome');
        }

        return view('patrol', ['current_time' => $current_time->toDateString()])->with('success', 'Scan Successful!');

    }

    // /**
    //  * Refining the scan store
    //  * 
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function scanManagement(Request $request)
    // {
    //     $user = Auth::user();

    //     $validated = $request->validate([
    //         'sector' => 'required',
    //         'sector_name' => 'required',
    //     ]);

    //     $last_clock_in = DB::table('scans')
    //     ->select('created_at')
    //     ->where('phone_number', '=', $user->phone_number)
    //     ->where('sector_name', '=', 'Clocking In')
    //     ->orderBy('created_at', 'desc')
    //     ->first();

    //     $last_shift = DB::table('shifts')
    //     ->where('first_name', '=', $user->firstname)
    //     ->orderBy('created_at', 'asc')
    //     ->first();

    //     // dd($last_clock_in);

    //     if($last_clock_in == null){
    //         $user = Auth::user();
    //         $current_time = Carbon::now();

    //         $scan= new Scan;
    //         $scan->phone_number = $user->phone_number;
    //         $scan->first_name = $user->firstname;
    //         $scan->latitude = $request->latitude;
    //         $scan->longitude = $request->longitude;
    //         $scan->sector = $request->sector;
    //         $scan->sector_name = $request->sector_name;
    //         $scan->time = $request->scan_time;
    //         $success = $scan->save();

    //         $shift = new Shift;
    //         $shift->phone_number = $user->phone_number;
    //         $shift->first_name = $user->firstname;
    //         $shift->last_name = $user->lastname;
    //         $shift->role = $user->role;
    //         $shift->clockin = $scan->created_at;
    //         $success2 = $shift->save();

    //         return redirect()->route('home');

    //     }

    //     $date = new DateTime($last_clock_in->created_at);
    //     $now = new DateTime();
    //     $diff = $date->diff($now)->format("%d days, %h hours and %i minutes");

    //     // dd('diff');

    //     if($request->sector_name == 'Clocking Out') {
    //         $in = new DateTime($last_clock_in->created_at);
    //         $out = new DateTime($request->created_at);
    //         $duration = $out->diff($in)->format("%d days, %h hours and %i minutes");

    //         $shift = DB::table('shifts')
    //                 ->where('phone_number', ($user->phone_number))
    //                 ->where('clockin', ($last_clock_in->created_at))
    //                 ->update([
    //                     'clockout' => $request->created_at,
    //                     'shift_duration' => $duration
    //                     ]);

    //         Auth::logout();
    //         $request->session()->invalidate();
    //         $request->session()->regenerateToken();
            
    //         return redirect()->route('welcome');
    //     }

    //     //Determine if User clocked out
    //     if($diff > "0 days, 12 hours and 0 minutes" && ($request->sector_name) == 'Clocking In' && $last_shift->clockout == null) 
    //     {
    //         dd('check');
    //         $shift = DB::table('shifts')
    //         ->where('phone_number', ($user->phone_number))
    //         ->where('clockin', ($last_clock_in->created_at))
    //         ->update([
    //             'clockout' => 'Did not clock out',
    //             'shift_duration' => 'Undeterminable'
    //             ]);

    //         Auth::logout();
    //         $request->session()->invalidate();
    //         $request->session()->regenerateToken();

    //         return redirect()->route('login');

    //     } else{
    //         $user = Auth::user();
    //         $current_time = Carbon::now();

    //         $scan= new Scan;
    //         $scan->phone_number = $user->phone_number;
    //         $scan->first_name = $user->firstname;
    //         $scan->latitude = $request->latitude;
    //         $scan->longitude = $request->longitude;
    //         $scan->sector = $request->sector;
    //         $scan->sector_name = $request->sector_name;
    //         $scan->time = $request->scan_time;
    //         $success = $scan->save();

    //         $shift = new Shift;
    //         $shift->phone_number = $user->phone_number;
    //         $shift->first_name = $user->firstname;
    //         $shift->last_name = $user->lastname;
    //         $shift->role = $user->role;
    //         $shift->clockin = $scan->created_at;
    //         $success2 = $shift->save();

    //         return view('patrol', ['current_time' => $current_time->toDateString()])->with('success', 'Successful Clock In');
    //     }
        
    //     if($diff < "0 days, 12 hours and 0 minutes" && ($request->sector_name) == 'Clocking In') 
    //     {
    //         return view('patrol', ['current_time' => $current_time->toDateString()])->with('success', 'Already Clocked in today');
    //     }

    //     if(($request->sector_name) == 'Clocking in')
    //     {
    //         // dd('reacched');
    //         $user = Auth::user();
    //         $current_time = Carbon::now();

    //         $scan= new Scan;
    //         $scan->phone_number = $user->phone_number;
    //         $scan->first_name = $user->firstname;
    //         $scan->latitude = $request->latitude;
    //         $scan->longitude = $request->longitude;
    //         $scan->sector = $request->sector;
    //         $scan->sector_name = $request->sector_name;
    //         $scan->time = $request->scan_time;
    //         $success = $scan->save();

    //         $shift = new Shift;
    //         $shift->phone_number = $user->phone_number;
    //         $shift->first_name = $user->firstname;
    //         $shift->last_name = $user->lastname;
    //         $shift->role = $user->role;
    //         $shift->clockin = $scan->created_at;
    //         $success2 = $shift->save();

    //         return view('patrol', ['current_time' => $current_time->toDateString()])->with('success', 'Successful Clock In');
    //     }
        
    // }

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


        $last_shift = DB::table('shifts')
        ->where('first_name', '=', $user->firstname)
        ->latest()
        ->first();

        $last_scan = new DateTime($last_scan->created_at);
        $last_clock_in = new DateTime($last_clock_in->created_at);

        $diff = $last_scan->diff($last_clock_in);
        //$hours_worked = explode( '.', $diff );
        
        // dd ($diff);

        $macAddr = exec('getmac');

        $user_agent = $_SERVER['HTTP_USER_AGENT'];


        // $absolute_path = realpath("C:\wamp64\www\security_guards\security_guards\cert\ProductionCertificate.cer");

        // print_r("Absolute path is: " . $absolute_path);

        $g2PublicKey ="file://cert/ProductionCertificate.cer";

        $file = file_get_contents('../cert/ProductionCertificate.cer', true);

        dd($file);

        // dd($last_shift);
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

                $location = (QrCode::where('code', $last_scanned_site->sector)->select('location')->first())->toArray();

            $scan= new Scan;
            $scan->phone_number = $user->phone_number;
            $scan->first_name = $user->firstname;
            $scan->role = $user->role;
            $scan->latitude = $last_scanned_site->latitude;
            $scan->longitude = $last_scanned_site->longitude;
            $scan->sector_name = 'Clocking Out';
            $scan->time = $last_scanned_site->time;
            $scan->location = $location['location'];
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

            $areas = [];
            foreach ($scanned_areas as $scanned_area)
            {
                array_push($areas, $scanned_area->sector_name);
            }

            $collection = collect($areas);
            
            return view('scanned_areas', ['current_time' => $current_time], compact('scanned_areas', 'collection'));
        }

    }
}
