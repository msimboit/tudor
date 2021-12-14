<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Scan;
use App\Models\Shift;
use App\Models\Issue;
use App\Models\QrCode;
use App\Models\Geolocation;
use App\Models\VisitorLog;
use App\Exports\ShiftsExport;
use App\Exports\GuardShiftExport;
use App\Exports\DailyGuardShiftExport;
use App\Exports\SpecificGuardShiftExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use DB;
use Log;
use Carbon\Carbon;


class ShiftController extends Controller
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

        if(in_array( (Auth::user()->role), $roles ))
        {
            return redirect()->route('home');
        }
        $users = User::where('role', '!=', 'admin')
                    ->where('role', '!=', 'guard')
                    ->where('role', '!=', 'guard_admin')
                    ->orderBy('firstname')
                    ->paginate(10);

        return view('shifts.shifts', ['users' => $users]);
    }

    /**
     * Display a listing of the guards shift reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardShiftsReport()
    {
        $roles = ['guard', 'management', 'operations', 'control', 'production'];

        if(in_array( (Auth::user()->role), $roles ))
        {
            return redirect()->route('home');
        }

        $guards = User::where('role', 'guard')->select('phone_number')->get();
        $current_time = Carbon::now();
        $shifts = Shift::where('created_at', '>', $current_time->subDays(7))
                        ->where('role', 'guard')
                        ->orderBy('created_at', 'desc')                
                        ->get();

        return view('shifts.guardShifts', ['shifts' => $shifts]);
    }

    /**
     * Display a list of the registered employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function employees()
    {

        if(Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }
        $employees = User::where('role', '!=', 'guard')
                    ->where('role', '!=', 'admin')
                    ->where('role', '!=', 'guard_admin')
                    ->orderBy('firstname')
                    ->paginate(10);

        return view('employees.employees', ['employees' => $employees]);
    }

    /**
     * Display a list of the registered clients.
     *
     * @return \Illuminate\Http\Response
     */
    public function clients()
    {

        if(Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }
        $clients = User::where('role','client')
                    ->orderBy('firstname')
                    ->paginate(10);

        return view('clients.clients', ['clients' => $clients]);
    }

    /**
     * Display a list of the registered guards.
     *
     * @return \Illuminate\Http\Response
     */
    public function guards()
    {
        $roles = ['guard', 'management', 'operations', 'control', 'production'];

        if(in_array( (Auth::user()->role), $roles ))
        {
            return redirect()->route('home');
        }
        
        $guards = User::where('role','guard')
                    ->orderBy('firstname')
                    ->get();

        return view('employees.guards', ['guards' => $guards]);
    }

    /**
     * Search for a specific date range of shifts.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchDate(Request $request)
    {   
        // dd($request->all());
        if($request->role == 'all')
        {
            $shifts = Shift::whereBetween('created_at', [$request->get('from'), $request->get('to')])
                        ->orderBy('created_at', 'desc')                
                        ->get();
        }
        else{
            
            $shifts = Shift::whereBetween('created_at', [$request->get('from'), $request->get('to')])
                        ->where('role', $request->role)
                        ->orderBy('created_at', 'desc')                
                        ->get();
        }

        $from = $request->get('from');
        $to = $request->get('to');
        
        // dd($shifts);

        return view('shifts.shiftsSearch', ['shifts' => $shifts, 'from' => $from, 'to' => $to]);
    }

    /**
     * Search for a specific location of shifts.
     *
     * @return \Illuminate\Http\Response
     */
    public function locationFilter(Request $request)
    {   
        // $langata = 'TCS000';
        // $baraka = 'TCS00';
        // $allimex = 'ALP';

        $location = $request->location;
        $current_time = Carbon::now();

        if($request->location == 'langata')
        {
            $sectors = (QrCode::where('location', 'langata')->select('code')->get())->toArray();
            $scanned_areas = Scan::whereIn('sector', $sectors)
                    ->where('role', 'guard')
                    ->where('created_at', '>', $current_time->subHours(24))
                    ->orderBy('created_at', 'desc')                
                    ->get();
            $location = "Lang'ata";
            return view('shifts.locationFilter', ['scanned_areas' => $scanned_areas, 'location' => $location]);
        }

        if($request->location == 'baraka')
        {
            $sectors = (QrCode::where('location', 'baraka')->select('code')->get())->toArray();
            $scanned_areas = Scan::whereIn('sector', $sectors)
                    ->where('role', 'guard')
                    ->where('created_at', '>', $current_time->subHours(24))
                    ->orderBy('created_at', 'desc')                
                    ->get();

            $location = "Baraka";
            return view('shifts.locationFilter', ['scanned_areas' => $scanned_areas, 'location' => $location]);
        }

        if($request->location == 'allimex')
        {
            $sectors = (QrCode::where('location', 'allimex')->select('code')->get())->toArray();
            $scanned_areas = Scan::whereIn('sector', $sectors)
                    ->where('role', 'guard')
                    ->where('created_at', '>', $current_time->subHours(24))
                    ->orderBy('created_at', 'desc')                
                    ->get();
            
            $location = "Allimex Plaza";
            return view('shifts.locationFilter', ['scanned_areas' => $scanned_areas, 'location' => $location]);
        }

        return redirect()->route('daily')->with('succes', 'No such location!');
    }

    /**
     * Show the specific guard information
     *
     * @return \Illuminate\Http\Response
     */
    public function info($id)
    {
        $guard = User::findOrFail($id);

        $guard_details = Shift::where('phone_number', $guard->phone_number)
                        ->orderBy('created_at', 'desc')
                        ->simplePaginate(30);
        
        // echo($guard_details);
        return view('shifts.shiftInfo', ['guard' => $guard], ['guard_details' => $guard_details]);
    }

    /**
     * Display specific guards scanned areas during that shift
     * 
     * @return \Illuminate\Http\Response
     */
    public function all_scanned_areas()
    {
        // dd(Auth::user());
        $user = Auth::user();
        $current_time = Carbon::now();
        
        $scanned_areas = DB::table('scans')
        // ->where('created_at', '<', $current_time)
        ->where('created_at', '>', $current_time->subHours(24))
        ->orderByDesc('created_at')
        ->paginate(5);
        
        return view('shifts.scanned_areas', ['current_time' => $current_time], ['scanned_areas' => $scanned_areas]);

    }

    /**
     * Display daily guard scanned areas during that day
     * 
     * @return \Illuminate\Http\Response
     */
    public function daily()
    {
        // dd(Auth::user());
        $user = Auth::user();
        $current_time = Carbon::now();

        $scanned_areas = DB::table('scans')
        // ->where('created_at', '<', $current_time)
        // ->where('created_at', '>', $current_time->subHours(24))
        ->whereDate('created_at', Carbon::today())
        ->where('role', 'guard')
        ->where('sector', '!=', null)
        ->orderByDesc('created_at')
        ->get();
        
        // dd($scanned_areas);
        return view('shifts.daily', ['current_time' => $current_time], ['scanned_areas' => $scanned_areas]);

    }

    /**
     * Display daily guard map
     * 
     * @return \Illuminate\Http\Response
     */
    public function map()
    {
        $current_time = Carbon::now();
        // $points = Scan::where('created_at', '>', $current_time->subHours(72))->where('role', 'guard')->get();
        // $points = Geolocation::select('first_name', 'latitude', 'longitude')->where('created_at', '>', $current_time->subHours(1))->get();
        $points = Geolocation::select('first_name', 'latitude', 'longitude')->get();
        return view('employees.map', ['points' => $points]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the visitor logs for the day
     */

     public function visitors()
     {
        if(Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }

        $visitor_log = VisitorLog::where('created_at', '>', Carbon::today() )->get();

        return view('visitors.visitorlogs', compact('visitor_log'));

     }

    /**
     * Display the visitor logs for the day
     */
    public function visitorInfo($id)
    {
       if(Auth::user()->role != 'admin')
       {
           return redirect()->route('home');
       }

       $visitor_log = VisitorLog::find($id);
    //    dd($visitor_log);

       return view('visitors.visitorInfo', compact('visitor_log'));

    }

    /**
     * Generate An Excel Form.
     */
    public function export() 
    {
        return Excel::download(new ShiftsExport, 'shifts.xlsx');
    }

    public function guardShiftexport() 
    {
        return (new GuardShiftExport('guard'))->download('guard-shift.xlsx');
    }

    public function dailyGuardShiftexport($location) 
    {
        return (new DailyGuardShiftExport($location))->download('guard-shift.xlsx');
    }

    public function specificGuardShiftexport(Request $request)
    {
        // dd($request->all());
        $from = $request->get('from'); 
        $to = $request->get('to');
        $location = $request->location;

        return (new SpecificGuardShiftExport($location, $from, $to))->download('guard-shift.xlsx');
    }
}
