<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Scan;
use App\Models\Shift;
use App\Models\Issue;
use App\Exports\ShiftsExport;
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
        if(Auth::user()->role == 'guard')
        {
            return redirect()->route('home');
        }
        $users = User::where('role', '!=', 'admin')
                    ->where('role', '!=', 'guard')
                    ->orderBy('firstname')
                    ->paginate(10);

        return view('shifts.shifts', ['users' => $users]);
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
                    ->orderBy('firstname')
                    ->paginate(10);

        return view('employees.employees', ['employees' => $employees]);
    }

    /**
     * Display a list of the registered guards.
     *
     * @return \Illuminate\Http\Response
     */
    public function guards()
    {

        if(Auth::user()->role != 'admin')
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
        ->where('created_at', '>', $current_time->subHours(24))
        ->where('role', 'guard')
        ->orderByDesc('created_at')
        ->get();
        
        // dd($scanned_areas);
        return view('shifts.daily', ['current_time' => $current_time], ['scanned_areas' => $scanned_areas]);

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
     * Generate An Excel Form.
     */
    public function export() 
    {
        return Excel::download(new ShiftsExport, 'shifts.xlsx');
    }
}
